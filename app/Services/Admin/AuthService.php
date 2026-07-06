<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Attempt to log the admin in and return a token.
     *
     * @param  array<string, mixed>  $credentials
     */
    public function attemptLogin(array $credentials): ?string
    {
        $user = User::where('email', $credentials['email'])->first();

        if (
            ! $user
            || $user->role !== 'admin'
            || ! Hash::check($credentials['password'], $user->password)
        ) {
            return null;
        }

        return $user->createToken('admin-dashboard')->plainTextToken;
    }

    /**
     * Log the admin out by revoking current token.
     */
    public function logout(Request $request): void
    {
        $user = $request->user();

        if ($user) {
            $user->forceFill([
                'last_seen_at' => now(),
            ])->save();

            $user->currentAccessToken()?->delete();
        }
    }
}
