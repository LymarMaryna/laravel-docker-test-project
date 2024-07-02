<?php

namespace App\Models;

use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Model;

class PersonalToken extends Model
{
    protected $fillable = [
        'user_id', 'token', 'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate and save a new personal token for a user.
     *
     * @param string $userId
     * @param int $expirationHours
     *
     * @return string
     */
    public static function generateForUser(string $userId, int $expirationHours = 2): string
    {
        $tokenValue = PersonalToken::where('user_id', $userId)
            ->where('expires_at', '>', now())
            ->latest()
            ->value('token');

        if (!$tokenValue) {
            $tokenValue = JWT::encode([
                'id' => $userId,
                'exp' => time() + (60 * 60) * $expirationHours,
            ], env('JWT_SECRET'),'HS256');

            self::create([
                'user_id' => $userId,
                'token' => $tokenValue,
                'expires_at' => now()->addHours($expirationHours),
            ]);
        }

        return $tokenValue;
    }
}
