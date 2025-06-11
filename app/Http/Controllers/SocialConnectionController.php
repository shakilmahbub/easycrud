<?php

namespace App\Http\Controllers;

use App\Enums\PlatformName;
use App\Models\SocialConnection; // Assuming this is your model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialConnectionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Eager load user if needed by view, though for $user->socialConnections, user is already available.
        // The main reason to eager load here would be if you were fetching connections without starting from $user.
        $connections = $user->socialConnections()->latest()->get();

        // Use the static cases() method we created in our class-based Enum
        $allPlatformCases = PlatformName::cases();
        $availablePlatforms = [];

        // Ensure platform values are consistently strings for comparison
        $connectedPlatformValues = $connections->pluck('platform')->map(function ($platform) {
            return is_object($platform) ? $platform->value : $platform;
        })->toArray();

        foreach ($allPlatformCases as $case) {
            // $case is an object with a 'value' property from our custom cases() method
            if (!in_array($case->value, $connectedPlatformValues)) {
                $availablePlatforms[] = $case; // Store the whole case object
            }
        }

        return view('social_connections.index', compact('connections', 'availablePlatforms'));
    }

    public function destroy(SocialConnection $connection)
    {
        // Authorization: Ensure the connection belongs to the authenticated user
        if ($connection->user_id !== Auth::id()) {
            return redirect()->route('social_connections.index')->with('error', 'Unauthorized action.');
        }

        // Get platform name for the message before deleting
        // Ensure platform attribute is correctly accessed (value if it's an enum object)
        $platformValue = is_object($connection->platform) ? $connection->platform->value : $connection->platform;
        $platformNameUI = ucfirst($platformValue);

        $connection->delete();

        return redirect()->route('social_connections.index')->with('status', $platformNameUI . ' connection successfully disconnected.');
    }
}
