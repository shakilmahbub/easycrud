<?php

namespace App\Services\Platforms;

use App\Enums\PlatformName;
use App\Interfaces\SocialPlatformServiceInterface;
use App\Models\SocialConnection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;

class FacebookService implements SocialPlatformServiceInterface
{
    public function getAuthScopes(): array
    {
        return ['email', 'public_profile', 'pages_show_list', 'pages_read_engagement', 'pages_manage_posts'];
    }

    public function getPlatformSpecificAccountData(SocialConnection $connection): array
    {
        if (!$connection->access_token || ($connection->platform !== PlatformName::FACEBOOK && $connection->platform->value !== PlatformName::FACEBOOK)) {
            Log::warning('FacebookService: Invalid connection or access token for Facebook page retrieval.', ['connection_id' => $connection->id]);
            return ['error' => 'Invalid connection or access token for Facebook page retrieval.', 'data' => []];
        }

        try {
            $accessToken = $connection->access_token;
            $response = Http::get("https://graph.facebook.com/v19.0/me/accounts", [
                'access_token' => $accessToken,
                'fields' => 'id,name,access_token,tasks',
            ]);

            if ($response->successful()) {
                $pagesData = $response->json()['data'] ?? [];
                return ['success' => true, 'data' => $pagesData];
            } else {
                Log::error('FacebookService: API error while fetching pages.', [
                    'connection_id' => $connection->id,
                    'response_status' => $response->status(),
                    'response_body' => $response->json() ?: $response->body()
                ]);
                return ['error' => 'Failed to fetch Facebook pages.', 'data' => [], 'details' => $response->json() ?: $response->body()];
            }
        } catch (Exception $e) {
            Log::error('FacebookService: Exception fetching Facebook pages.', [
                'connection_id' => $connection->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return ['error' => 'Exception fetching Facebook pages: ' . $e->getMessage(), 'data' => []];
        }
    }

    public function formatAccountData(array $apiAccountData): array
    {
        $formattedPages = [];
        foreach ($apiAccountData as $page) {
            if (isset($page['id']) && isset($page['name'])) {
                 $formattedPages[] = [
                    'id' => $page['id'],
                    'name' => $page['name'],
                ];
            }
        }
        return $formattedPages;
    }

    public function afterAuthentication(SocialConnection $connection, SocialiteUserContract $socialUser): void
    {
        Log::info('FacebookService: afterAuthentication called.', ['user_id' => $connection->user_id, 'facebook_user_id' => $socialUser->getId()]);
    }

    public function getPostAuthRedirectRoute(SocialConnection $connection): string
    {
        return route('facebook.select');
    }

    public function post(SocialConnection $connection, string $targetId, array $postData): array
    {
        // Ensure platform is checked correctly, especially if $connection->platform is an Enum object
        $platformValue = is_string($connection->platform) ? $connection->platform : $connection->platform->value;
        if (!$connection->access_token || $platformValue !== PlatformName::FACEBOOK) {
            return ['error' => true, 'message' => 'Invalid connection or access token for Facebook post.'];
        }

        $postType = $postData['type'] ?? 'text';
        $accessToken = $connection->access_token; // User access token

        // TODO: Implement logic to use page-specific access token from $connection->metadata
        // if $targetId is a page_id and a page-specific token is stored and valid.
        // Example:
        // $pageTokens = $connection->metadata['page_access_tokens'] ?? [];
        // if (isset($pageTokens[$targetId])) {
        //    $accessToken = decrypt($pageTokens[$targetId]); // Assuming it was encrypted
        // }


        try {
            $endpointUrl = "";
            $payload = [];

            if ($postType === 'text' || $postType === 'link') { // Consolidate text and link posts as they use /feed
                if (empty($postData['text']) && $postType === 'text') { // Text is required for 'text' type
                    return ['error' => true, 'message' => 'Text content is missing for text post.'];
                }
                if (empty($postData['link_url']) && $postType === 'link') { // Link URL is required for 'link' type
                     return ['error' => true, 'message' => 'Link URL is missing for link post.'];
                }

                $endpointUrl = "https://graph.facebook.com/v19.0/{$targetId}/feed";
                $payload = [
                    'access_token' => $accessToken,
                ];
                if (!empty($postData['text'])) {
                    $payload['message'] = $postData['text'];
                }
                if (!empty($postData['link_url'])) {
                    $payload['link'] = $postData['link_url'];
                }
            }
            // elseif ($postType === 'image') {
            //     // TODO: Implement image posting logic (e.g., to /{targetId}/photos)
            //     // Requires 'image_url' or file upload handling.
            //     // $endpointUrl = "https://graph.facebook.com/v19.0/{$targetId}/photos";
            //     // $payload = [ 'url' => $postData['image_url'], 'caption' => $postData['text'] ?? '', 'access_token' => $accessToken ];
            //     Log::warning('FacebookService: Image post type not fully implemented yet.');
            //     return ['error' => true, 'message' => 'Image posting not yet implemented for Facebook.'];
            // }
            // elseif ($postType === 'video') {
            //     // TODO: Implement video posting logic (e.g., to /{targetId}/videos)
            //     // Requires 'video_url' or file upload handling.
            //     Log::warning('FacebookService: Video post type not fully implemented yet.');
            //     return ['error' => true, 'message' => 'Video posting not yet implemented for Facebook.'];
            // }
            else {
                Log::warning("FacebookService: Unsupported post type '{$postType}'.", ['target_id' => $targetId]);
                return ['error' => true, 'message' => "Unsupported post type '{$postType}' for Facebook."];
            }

            if (empty($endpointUrl)) { // Should not happen if logic is correct
                return ['error' => true, 'message' => "Could not determine API endpoint for post type '{$postType}'."];
            }

            $response = Http::post($endpointUrl, $payload);

            if ($response->successful()) {
                Log::info("FacebookService: Successfully posted to {$targetId}.", ['type' => $postType, 'response_id' => $response->json()['id'] ?? 'N/A']);
                return ['success' => true, 'data' => $response->json()];
            } else {
                Log::error("FacebookService: Post Error to {$targetId}: ", ['type' => $postType, 'response_status' => $response->status(), 'response_body' => $response->json() ?: $response->body()]);
                return ['error' => true, 'message' => 'Failed to post to Facebook.', 'details' => $response->json() ?: $response->body()];
            }
        } catch (Exception $e) {
            Log::error("FacebookService: Exception posting to Facebook target {$targetId} (type: {$postType}): ", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return ['error' => true, 'message' => 'Exception during Facebook post: ' . $e->getMessage()];
        }
    }
}
