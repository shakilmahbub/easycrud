<?php

namespace App\Services\Platforms;

use App\Enums\PlatformName;
use App\Interfaces\SocialPlatformServiceInterface;
use App\Models\SocialConnection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;

class PinterestService implements SocialPlatformServiceInterface
{
    public function post(SocialConnection $connection, string $targetId, array $postData): array
    {
        
    }
}
