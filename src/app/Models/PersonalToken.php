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
    public static function getOrCreateTokenForUser(string $userId, int $expirationHours = 2): string
    {
        $token = PersonalToken::where('user_id', $userId)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$token) {
            try {
                $token = self::generateUserToken($userId, $expirationHours);
            } catch (\Exception $e) {
                return '';  // Return empty string if token generation fails
            }
        }

        return $token->token ?? '';
    }

    /**
     * @param string $userId
     * @param int $expirationHours
     *
     * @return PersonalToken
     *
     * @throws \Exception
     */
    private static function generateUserToken(string $userId, int $expirationHours = 2): PersonalToken
    {
        try {
            // Delete old tokens if needed
            // PersonalToken::where('user_id', $userId)->delete();

            $expTime = now()->addHours($expirationHours);
            $tokenValue = JWT::encode
            (
                [
                    'id' => $userId,
                    'exp' => $expTime,
                ],
                config('api.jwt_secret'),
                config('api.jwt_alg')
            );

            return self::create([
                'user_id' => $userId,
                'token' => $tokenValue,
                'expires_at' => $expTime,
            ]);

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
