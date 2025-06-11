<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\PlatformName; // Assuming App\Enums\PlatformName is the class-based enum
use Illuminate\Database\Eloquent\Casts\AsArrayObject; // Alternative for metadata cast

class SocialConnection extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'social_connections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'platform',
        'platform_user_id',
        'access_token',
        'refresh_token', // Added refresh token
        'token_expires_at',
        'scopes',
        'metadata',
        // Old Facebook-specific fields like page_id, page_name are removed from fillable
        // as they will be part of 'metadata' or handled by specific methods if needed.
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'access_token',
        'refresh_token', // Hide refresh token as well
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'access_token' => 'encrypted',
        'refresh_token' => 'encrypted',
        'token_expires_at' => 'datetime',
        'scopes' => 'array',
        'metadata' => 'array', // Or AsArrayObject::class for more advanced object-like interaction
        // For class-based "enum":
        // 'platform' => 'string', // Store as string, validation can be done elsewhere or via custom cast
        // If PHP 8.1+ native enums were used and App\Enums\PlatformName was a native backed enum:
        'platform' => PlatformName::class,
    ];

    /**
     * Get the user that owns the social connection.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to get Facebook Page ID from metadata if this is a Facebook connection.
     *
     * @return string|null
     */
    public function getFacebookPageId(): ?string
    {
        if ($this->platform === PlatformName::FACEBOOK || (is_object($this->platform) && $this->platform->value === PlatformName::FACEBOOK)) {
            return $this->metadata['page_id'] ?? null;
        }
        return null;
    }

    /**
     * Helper to get Facebook Page Name from metadata if this is a Facebook connection.
     *
     * @return string|null
     */
    public function getFacebookPageName(): ?string
    {
        if ($this->platform === PlatformName::FACEBOOK || (is_object($this->platform) && $this->platform->value === PlatformName::FACEBOOK)) {
            return $this->metadata['page_name'] ?? null;
        }
        return null;
    }

    /**
     * Helper to get Facebook Group ID from metadata if this is a Facebook connection.
     *
     * @return string|null
     */
    public function getFacebookGroupId(): ?string
    {
        if ($this->platform === PlatformName::FACEBOOK || (is_object($this->platform) && $this->platform->value === PlatformName::FACEBOOK)) {
            return $this->metadata['group_id'] ?? null;
        }
        return null;
    }

    /**
     * Helper to get Facebook Group Name from metadata if this is a Facebook connection.
     *
     * @return string|null
     */
    public function getFacebookGroupName(): ?string
    {
        if ($this->platform === PlatformName::FACEBOOK || (is_object($this->platform) && $this->platform->value === PlatformName::FACEBOOK)) {
            return $this->metadata['group_name'] ?? null;
        }
        return null;
    }
}
