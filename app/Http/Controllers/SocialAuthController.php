<?php

namespace App\Http\Controllers;

use App\Enums\PlatformName;
use App\Models\SocialConnection;
use App\Models\User;
use App\Services\SocialPlatformManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;
// Ensure SocialiteUser contract is imported if type-hinted in service interface
// use Laravel\Socialite\Contracts\User as SocialiteUserContract;

class SocialAuthController extends Controller
{
    const ID_NAME_SEPARATOR = '__SEP__'; // Used for Facebook page/group selection

    /**
     * Redirect the user to the provider's authentication page.
     *
     * @param string $platform
     * @param SocialPlatformManager $platformManager
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(string $platform, SocialPlatformManager $platformManager)
    {
        if (!in_array($platform, PlatformName::getValues())) {
            return redirect('/login')->with('error', 'Unsupported social media platform.');
        }

        try {
            $platformService = $platformManager->resolve($platform);
            $scopes = $platformService->getAuthScopes();
            return Socialite::driver($platform)->scopes($scopes)->redirect();
        } catch (Exception $e) {
            Log::error("Error resolving or redirecting to platform {$platform}: " . $e->getMessage());
            return redirect('/login')->with('error', 'Could not initiate social login for ' . ucfirst($platform) . '.');
        }
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param string $platform
     * @param SocialPlatformManager $platformManager
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(string $platform, SocialPlatformManager $platformManager)
    {
        if (!in_array($platform, PlatformName::getValues())) {
            return redirect('/login')->with('error', 'Unsupported social media platform callback.');
        }

        try {
            $socialUser = Socialite::driver($platform)->user();

            if (empty($socialUser->getEmail())) {
                Log::warning(ucfirst($platform) . " callback: Email not provided.", ['social_user_id' => $socialUser->getId()]);
                return redirect('/login')->with('error', 'No email address returned from ' . ucfirst($platform) . '.');
            }

            $localUser = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName(),
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                ]
            );

            $connectionMetaData = [];
            // Initial metadata can be set here based on platform if needed
            // For Facebook, specific page/group data is handled later in its dedicated flow.
            if ($platform === PlatformName::FACEBOOK) {
                $connectionMetaData['status'] = 'awaiting_page_group_selection';
            }

            // Use $connection variable to store the created/updated SocialConnection instance
            $connection = SocialConnection::updateOrCreate(
                [
                    'user_id' => $localUser->id,
                    'platform' => $platform,
                    'platform_user_id' => $socialUser->getId(),
                ],
                [
                    'access_token' => $socialUser->token,
                    'refresh_token' => $socialUser->refreshToken,
                    'token_expires_at' => $socialUser->expiresIn ? now()->addSeconds($socialUser->expiresIn) : null,
                    'scopes' => $socialUser->scopes ?? [],
                    'metadata' => $connectionMetaData, // Store initial or updated metadata
                ]
            );

            Auth::login($localUser);

            $platformService = $platformManager->resolve($platform);
            // Pass the just created/updated $connection and $socialUser to afterAuthentication
            $platformService->afterAuthentication($connection, $socialUser);

            $redirectRoutePath = $platformService->getPostAuthRedirectRoute($connection);
            $statusMessage = 'Successfully connected your ' . ucfirst($platform) . ' account!';

            // Customize message for Facebook if it's redirecting to page/group selection
            if ($platform === PlatformName::FACEBOOK) {
                // Assuming getPostAuthRedirectRoute for Facebook returns route('facebook.select')
                // A more robust check might be to compare $redirectRoutePath with the actual route string.
                // For simplicity, we assume if it's Facebook, the message is adjusted.
                $statusMessage .= ' Please select a page/group if desired.';
            }

            // Use redirect()->to() for path if getPostAuthRedirectRoute returns a path string
            // or redirect()->route() if it returns a route name.
            // Assuming getPostAuthRedirectRoute returns a named route for now.
            return redirect()->route($redirectRoutePath)->with('status', $statusMessage);

        } catch (Exception $e) {
            Log::error(ucfirst($platform) . " callback error: " . $e->getMessage(), ['exception_trace' => $e->getTraceAsString()]);
            return redirect('/login')->with('error', 'Failed to connect with ' . ucfirst($platform) . '. Details: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for selecting a Facebook Page and/or Group.
     * This method is Facebook-specific.
     *
     * @param Request $request
     * @param SocialPlatformManager $platformManager
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showSelectPageGroupForm(Request $request, SocialPlatformManager $platformManager)
    {
        $user = $request->user();
        $connection = $user->socialConnections()
                           ->where('platform', PlatformName::FACEBOOK)
                           ->first();

        if (!$connection || !$connection->access_token) {
            session()->flash('error', 'Facebook account not connected or access token missing.');
            return redirect()->route('social.redirect', ['platform' => PlatformName::FACEBOOK]);
        }

        $pages = [];
        try {
            $facebookService = $platformManager->resolve(PlatformName::FACEBOOK);
            $apiResponse = $facebookService->getPlatformSpecificAccountData($connection);

            if (!empty($apiResponse['success']) && isset($apiResponse['data'])) {
                $pages = $facebookService->formatAccountData($apiResponse['data']);
            } elseif (!empty($apiResponse['error'])) {
                session()->flash('error', 'Could not fetch Facebook pages: ' . ($apiResponse['message'] ?? $apiResponse['error']));
                 Log::error('Facebook API error in showSelectPageGroupForm', ['details' => $apiResponse['details'] ?? 'N/A']);
            }
        } catch (Exception $e) {
            Log::error('Exception fetching Facebook pages in showSelectPageGroupForm: ' . $e->getMessage(), ['user_id' => $user->id]);
            session()->flash('error', 'An error occurred while trying to fetch your Facebook pages.');
        }

        $mockGroups = [
            ['id' => 'mock_group_abc', 'name' => 'Community Group Alpha (Mock)'],
            ['id' => 'mock_group_def', 'name' => 'Support Forum Bravo (Mock)'],
        ];

        return view('facebook.select_page_group', [
            'pages' => $pages,
            'groups' => $mockGroups,
            'connection' => $connection,
        ]);
    }

    /**
     * Save the selected Facebook Page and/or Group.
     * This method is Facebook-specific.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function savePageGroupSelection(Request $request)
    {
        $user = $request->user();
        $connection = $user->socialConnections()
                           ->where('platform', PlatformName::FACEBOOK)
                           ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'selected_page_id' => 'nullable|string',
            'selected_group_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('facebook.select')
                        ->withErrors($validator)
                        ->withInput();
        }

        $validated = $validator->validated();
        $metadata = $connection->metadata ?? [];

        if (!empty($validated['selected_page_id'])) {
            $pageParts = explode(self::ID_NAME_SEPARATOR, $validated['selected_page_id']);
            $metadata['page_id'] = $pageParts[0];
            $metadata['page_name'] = $pageParts[1] ?? $pageParts[0];
        } else {
            $metadata['page_id'] = null;
            $metadata['page_name'] = null;
        }

        if (!empty($validated['selected_group_id'])) {
            $groupParts = explode(self::ID_NAME_SEPARATOR, $validated['selected_group_id']);
            $metadata['group_id'] = $groupParts[0];
            $metadata['group_name'] = $groupParts[1] ?? $groupParts[0];
        } else {
            $metadata['group_id'] = null;
            $metadata['group_name'] = null;
        }

        // Update the specific metadata fields related to page/group selection for Facebook.
        // Other initial metadata like 'connection_type' (if set before) will be preserved
        // because we are modifying the $metadata array fetched from the model.
        $connection->metadata = $metadata;
        $connection->save();

        session()->flash('status', 'Facebook Page/Group selection saved successfully!');
        $redirectRouteName = app('router')->has('home') ? 'home' : 'dashboard';
        // Ensure 'dashboard' is a valid route name if 'home' isn't, or use a path like '/'.
        if (!app('router')->has($redirectRouteName)) {
            $redirectRouteName = '/'; // Fallback to root path
            return redirect($redirectRouteName);
        }
        return redirect()->route($redirectRouteName);
    }
}
