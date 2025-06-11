<?php

namespace App\Interfaces;

use App\Models\SocialConnection;

interface SocialPlatformServiceInterface
{
    public function getAuthScopes(): array;
    public function getPlatformSpecificAccountData(SocialConnection $connection): array; // e.g., pages for FB, channels for YT
    public function formatAccountData(array $apiAccountData): array; // To standardize [{id: '...', name: '...'}, ...]

    /**
     * Post content to the social media platform.
     *
     * @param SocialConnection $connection The social connection instance.
     * @param string $targetId The ID of the target (e.g., page ID, group ID, user ID for timeline).
     * @param array $postData Data for the post. Expected structure:
     *                        ['type' => 'text', 'text' => 'Your message content.']
     *                        ['type' => 'link', 'text' => 'Optional message.', 'link_url' => 'URL to share']
     *                        ['type' => 'image', 'text' => 'Optional caption.', 'image_url' => 'URL of the image']
     *                        ['type' => 'video', 'text' => 'Optional description.', 'video_url' => 'URL of the video']
     *                        Additional platform-specific options can be included in $postData.
     * @return array Response from the platform, typically ['success' => true/false, 'data' => ..., 'error' => ...].
     */
    public function post(SocialConnection $connection, string $targetId, array $postData): array;

    /**
     * Perform any actions specific to the platform after successful authentication and SocialConnection update.
     * For example, fetching initial data, setting up webhooks, etc.
     *
     * @param SocialConnection $connection The saved or updated social connection.
     * @param \Laravel\Socialite\Contracts\User $socialUser The user object from Socialite.
     * @return void
     */
    public function afterAuthentication(SocialConnection $connection, \Laravel\Socialite\Contracts\User $socialUser): void;

    /**
     * Get the redirect route specific to this platform after authentication.
     *
     * @param SocialConnection $connection The saved or updated social connection.
     * @return string The route name or path.
     */
    public function getPostAuthRedirectRoute(SocialConnection $connection): string;
}
