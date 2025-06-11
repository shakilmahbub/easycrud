<?php

namespace App\Services;

use App\Enums\PlatformName;
use App\Interfaces\SocialPlatformServiceInterface;
use App\Services\Platforms\FacebookService;
// Import other platform services as they are created, e.g.:
// use App\Services\Platforms\LinkedInService;
// use App\Services\Platforms\TwitterService;
use InvalidArgumentException;

class SocialPlatformManager
{
    /**
     * Resolve the appropriate platform service.
     *
     * @param string $platformName The value from PlatformName enum (e.g., PlatformName::FACEBOOK->value)
     * @return SocialPlatformServiceInterface
     * @throws InvalidArgumentException If the platform is not supported.
     */
    public function resolve(string $platformName): SocialPlatformServiceInterface
    {
        // It's good practice to ensure $platformName is a valid value from the Enum if not already guaranteed.
        // For example, by checking against PlatformName::getValues() if that method exists on your Enum class.

        if ($platformName === PlatformName::FACEBOOK) { // Direct comparison with class constant
            return new FacebookService();
        }
        // elseif ($platformName === PlatformName::LINKEDIN) { // Example for another platform
        //     return new LinkedInService();
        // }
        // Add other platforms here as new services are implemented
        // elseif ($platformName === PlatformName::TWITTER) {
        //     return new TwitterService();
        // }

        throw new InvalidArgumentException("Unsupported social media platform: {$platformName}");
    }

    /**
     * Get an array of all supported platform identifiers.
     * This can be useful for validation or frontend loops.
     *
     * @return array
     */
    public function getSupportedPlatforms(): array
    {
        // This should ideally be dynamic or based on registered services if the manager becomes more complex.
        // For now, it can reflect the implemented services.
        // Relies on the PlatformName enum (class-based) having a getValues() method or similar.
        if (method_exists(PlatformName::class, 'getValues')) {
            return PlatformName::getValues();
        }
        // Fallback if getValues isn't on the enum or for manual listing:
        return [PlatformName::FACEBOOK]; // Only Facebook is implemented in this example
    }
}
