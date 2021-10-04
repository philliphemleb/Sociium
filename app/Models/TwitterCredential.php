<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitterCredential extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'oauth_token',
        'oauth_verifier',
    ];

    /**
     * Get the user that owns this twitter account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
