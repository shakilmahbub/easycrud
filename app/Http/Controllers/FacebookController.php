<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FacebookConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class FacebookController extends Controller
{
    const ID_NAME_SEPARATOR = '__SEP__';

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToFacebook()
    {
        $scopes = ['email', 'public_profile', 'pages_show_list', 'pages_read_engagement'];
        return Socialite::driver('facebook')->scopes($scopes)->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $fbUserId = $facebookUser->getId();
            $fbName = $facebookUser->getName();
            $fbEmail = $facebookUser->getEmail();
            $fbToken = $facebookUser->token;
            $fbExpiresIn = $facebookUser->expiresIn;
            $fbScopes = $facebookUser->scopes ?? [];

            $tokenExpiresAt = $fbExpiresIn ? now()->addSeconds($fbExpiresIn) : null;

            if (empty($fbEmail)) {
                Log::error('Facebook callback error: Email not provided by Facebook for user ID ' . $fbUserId, ['scopes' => $fbScopes]);
                return redirect('/login')->with('error', 'Could not retrieve email from Facebook. Please ensure your Facebook account has a verified email, that you granted email permission, or try another login method.');
            }

            $localUser = User::where('email', $fbEmail)->first();

            if (!$localUser) {
                $localUser = User::create([
                    'name' => $fbName,
                    'email' => $fbEmail,
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                ]);
            }

            FacebookConnection::updateOrCreate(
                [
                    'user_id' => $localUser->id,
                    'facebook_user_id' => $fbUserId,
                ],
                [
                    'access_token' => $fbToken,
                    'scopes' => $fbScopes,
                    'token_expires_at' => $tokenExpiresAt,
                ]
            );

            Auth::login($localUser);

            return redirect()->route('facebook.select');

        } catch (Exception $e) {
            Log::error('Facebook callback error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect('/login')->with('error', 'Failed to connect with Facebook: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for selecting a Facebook Page and/or Group.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showSelectPageGroupForm(Request $request)
    {
        $user = $request->user();
        $facebookConnection = $user->facebookConnection()->first();

        if (!$facebookConnection || !$facebookConnection->access_token) {
            session()->flash('error', 'Facebook account not connected or access token missing. Please connect your Facebook account first.');
            return redirect()->route('facebook.redirect');
        }

        $pages = [];
        $accessToken = $facebookConnection->access_token;

        try {
            $response = Http::get("https://graph.facebook.com/me/accounts", [
                'access_token' => $accessToken,
                'fields' => 'id,name,access_token,tasks',
            ]);

            if ($response->successful()) {
                $apiData = $response->json();
                if (isset($apiData['data'])) {
                    foreach ($apiData['data'] as $page) {
                        $pages[] = ['id' => $page['id'], 'name' => $page['name']];
                    }
                }
            } else {
                Log::error('Facebook API error while fetching pages: ' . $response->body(), [
                    'user_id' => $user->id,
                    'status_code' => $response->status(),
                ]);
                 session()->flash('error', 'Could not fetch pages from Facebook. Error: ' . ($response->json()['error']['message'] ?? 'Unknown API error'));
            }
        } catch (Exception $e) {
            Log::error('Exception while fetching Facebook pages: ' . $e->getMessage(), ['user_id' => $user->id]);
            session()->flash('error', 'An error occurred while trying to fetch your Facebook pages.');
        }

        $mockGroups = [
            ['id' => 'mock_group_abc', 'name' => 'Community Group Alpha (Mock)'],
            ['id' => 'mock_group_def', 'name' => 'Support Forum Bravo (Mock)'],
        ];

        return view('facebook.select_page_group', [
            'pages' => $pages,
            'groups' => $mockGroups,
            'connection' => $facebookConnection,
        ]);
    }

    /**
     * Save the selected Facebook Page and/or Group.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function savePageGroupSelection(Request $request)
    {
        $user = $request->user();
        $facebookConnection = $user->facebookConnection()->first();

        if (!$facebookConnection) {
            session()->flash('error', 'Facebook account not connected.');
            return redirect()->route('facebook.redirect');
        }

        $validator = Validator::make($request->all(), [
            'selected_page_id' => 'nullable|string', // Now stores "id__SEP__name" or empty
            'selected_group_id' => 'nullable|string', // Now stores "id__SEP__name" or empty
        ]);

        if ($validator->fails()) {
            return redirect()->route('facebook.select')
                        ->withErrors($validator)
                        ->withInput();
        }

        $validated = $validator->validated();
        $updateData = [];

        // Process Page Selection
        if (!empty($validated['selected_page_id'])) {
            $pageParts = explode(self::ID_NAME_SEPARATOR, $validated['selected_page_id']);
            $updateData['page_id'] = $pageParts[0];
            $updateData['page_name'] = $pageParts[1] ?? $pageParts[0]; // Default to ID if name part is missing
        } else {
            $updateData['page_id'] = null;
            $updateData['page_name'] = null;
        }

        // Process Group Selection
        if (!empty($validated['selected_group_id'])) {
            $groupParts = explode(self::ID_NAME_SEPARATOR, $validated['selected_group_id']);
            $updateData['group_id'] = $groupParts[0];
            $updateData['group_name'] = $groupParts[1] ?? $groupParts[0]; // Default to ID if name part is missing
        } else {
            $updateData['group_id'] = null;
            $updateData['group_name'] = null;
        }

        $facebookConnection->update($updateData);

        session()->flash('status', 'Facebook Page/Group selection saved successfully!');
        $redirectRoute = app('router')->has('home') ? 'home' : '/dashboard';
        return redirect()->route($redirectRoute);
    }
}
