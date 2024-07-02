<?php

namespace App\Http\Controllers;

use App\Models\PersonalToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function issueToken(Request $request): JsonResponse
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Check if the user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->registerAndAuthenticateUser($request->email, $request->password);
        } else {
            return $this->authenticateExistingUser($user, $request->password);
        }
    }

    /**
     * Authenticate an existing user.
     *
     * @param User $user
     * @param string $password
     *
     * @return JsonResponse
     */
    private function authenticateExistingUser(User $user, string $password): JsonResponse
    {
        if (Auth::attempt(['email' => $user->email, 'password' => $password])) {
            $token = PersonalToken::getOrCreateTokenForUser($user->id);
            if (!$token) {
                return response()->json(['error' => 'Token generation failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                return response()->json(['access_token' => $token], Response::HTTP_OK);
            }
        }

        return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Register a new user and authenticate.
     *
     * @param string $email
     * @param string $password
     *
     * @return JsonResponse
     */
    private function registerAndAuthenticateUser(string $email, string $password): JsonResponse
    {
        try {
            $user = User::create([
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $token = PersonalToken::getOrCreateTokenForUser($user->id);

            if (!$token) {
                return response()->json(['error' => 'Token generation failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                return response()->json(['access_token' => $token], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registration failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
