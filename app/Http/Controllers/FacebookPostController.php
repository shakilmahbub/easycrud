<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SocialConnection;
use App\Enums\PlatformName;
use App\Jobs\SendSocialPostJob;
use Illuminate\Support\Facades\Log;
use Exception;

class FacebookPostController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $connection = $user->socialConnections()
                           ->where('platform', PlatformName::FACEBOOK)
                           ->first();

        $pageId = $connection ? ($connection->metadata['page_id'] ?? null) : null;
        $groupId = $connection ? ($connection->metadata['group_id'] ?? null) : null;

        if (!$connection || (!$pageId && !$groupId)) {
            return redirect()->route('facebook.select')
                ->with('error', 'Please select a Facebook Page or Group before creating a post.');
        }

        return view('facebook.posts.create', compact('connection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_content' => 'required|string|max:5000',
            'target_type' => 'required|in:page,group',
            // Add validation for link_url if you add that field to the form
            // 'link_url' => 'nullable|url|max:2048',
        ]);

        $user = Auth::user();
        $connection = $user->socialConnections()
                           ->where('platform', PlatformName::FACEBOOK)
                           ->first();

        if (!$connection) {
            return redirect()->route('social.redirect', ['platform' => PlatformName::FACEBOOK])
                             ->with('error', 'Facebook connection not found. Please reconnect.');
        }

        if (empty($connection->access_token)) {
             return back()->with('error', 'Facebook access token is missing or invalid. Please reconnect your account.')->withInput();
        }

        $targetId = null;
        $pageId = $connection->metadata['page_id'] ?? null;
        $groupId = $connection->metadata['group_id'] ?? null;

        if ($request->target_type === 'page' && $pageId) {
            $targetId = $pageId;
        } elseif ($request->target_type === 'group' && $groupId) {
            $targetId = $groupId;
        }

        if (!$targetId) {
            return back()->with('error', 'Invalid target selected or target ID not found in your connection settings.')->withInput();
        }

        // Prepare $postData array
        $postData = [
            'type' => 'text', // Default to text post
            'text' => $request->post_content,
        ];

        // Example for handling a link post if a 'link_url' field were added to the form:
        // if ($request->filled('link_url')) {
        //    $postData['type'] = 'link';
        //    $postData['link_url'] = $request->link_url;
        //    // The 'text' field can serve as the message accompanying the link
        // }

        // TODO: Add logic for other post types (image, video) based on form input.
        // This would involve adding corresponding fields to the 'create.blade.php' form
        // and then populating $postData with 'image_url', 'video_url', etc.

        try {
            // Dispatch the job with the SocialConnection object, targetId, and the postData array
            SendSocialPostJob::dispatch($connection, $targetId, $postData);

            session()->flash('status', 'Your post has been queued for submission to Facebook!');
            return redirect()->route('facebook.post.create');

        } catch (Exception $e) {
            Log::error('Error dispatching SendSocialPostJob: ', [
                'user_id' => $user->id,
                'connection_id' => $connection->id,
                'target_id' => $targetId,
                'exception_message' => $e->getMessage(),
            ]);
            return back()->withInput()->with('error', 'An unexpected error occurred while trying to queue your post.');
        }
    }
}
