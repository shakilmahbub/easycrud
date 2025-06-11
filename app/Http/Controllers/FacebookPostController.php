<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FacebookConnection;
use App\Jobs\SendFacebookPostJob; // Import the Job class
use Illuminate\Support\Facades\Log; // Log is still useful for controller-level issues
// Http facade is no longer directly used here, but good to keep if other methods might use it.
// use Illuminate\Support\Facades\Http;
use Exception;

class FacebookPostController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $connection = $user->loadMissing('facebookConnection')->facebookConnection;

        if (!$connection || (!$connection->page_id && !$connection->group_id)) {
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
        ]);

        $user = Auth::user();
        $connection = $user->loadMissing('facebookConnection')->facebookConnection;

        if (!$connection) {
            return redirect()->route('facebook.select')->with('error', 'Facebook connection not found.');
        }

        $targetId = null;
        $accessToken = $connection->access_token;

        if (empty($accessToken)) {
             return back()->with('error', 'Facebook access token is missing or invalid. Please reconnect your account.')->withInput();
        }

        if ($request->target_type === 'page' && $connection->page_id) {
            $targetId = $connection->page_id;
        } elseif ($request->target_type === 'group' && $connection->group_id) {
            $targetId = $connection->group_id;
        }

        if (!$targetId) {
            return back()->with('error', 'Invalid target selected or target ID not found.')->withInput();
        }

        try {
            // Dispatch the job
            // Note: For local development, if the queue driver is 'sync' (default),
            // this job will execute immediately in the same request cycle.
            // For true background processing, configure a different queue driver (e.g., database, Redis)
            // and run a queue worker: `php artisan queue:work`
            SendFacebookPostJob::dispatch($targetId, $request->post_content, $accessToken, $request->target_type);

            session()->flash('status', 'Your post has been queued for submission to Facebook!');
            return redirect()->route('facebook.post.create');

        } catch (Exception $e) {
            // This would typically catch issues with dispatching the job itself,
            // or if the queue is 'sync' and the job throws an unhandled exception immediately.
            Log::error('Error dispatching SendFacebookPostJob: ', [
                'user_id' => $user->id,
                'target_id' => $targetId,
                'exception_message' => $e->getMessage(),
            ]);
            return back()->withInput()->with('error', 'An unexpected error occurred while trying to queue your post.');
        }
    }
}
