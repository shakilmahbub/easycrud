<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacebookConnection extends Model
{
    use HasFactory; // Optional: if you plan to use factories for this model

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'facebook_connections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'facebook_user_id',
        'page_id',
        'page_name',
        'group_id',
        'group_name',
        'access_token',
        'scopes',
        'token_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'access_token', // Good practice to hide tokens from direct serialization
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'access_token' => 'encrypted',
        'token_expires_at' => 'datetime',
        'scopes' => 'array', // Store scopes as JSON, cast to array
    ];

    /**
     * Get the user that owns the Facebook connection.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
