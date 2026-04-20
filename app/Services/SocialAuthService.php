<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthService
{
    public function loginOrCreateUser($socialUser, string $provider): User
    {
        $providerId = $socialUser->getId();
        $email = $socialUser->getEmail();

        if (!$email) {
            $email = $provider . '_' . $providerId . '@placeholder.local';
        }

        $user = User::where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();

        if ($user) {
            Auth::login($user, true);
            return $user;
        }

        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            $existingUser->update([
                'provider' => $provider,
                'provider_id' => $providerId,
                'name' => $socialUser->getName() ?? $existingUser->name,
                'avatar' => $socialUser->getAvatar() ?? $existingUser->avatar,
            ]);

            Auth::login($existingUser, true);
            return $existingUser;
        }

        $user = User::create([
            'name' => $socialUser->getName() ?? 'User Social',
            'student_id' => '20201234',
            'email' => $email,
            'avatar' => $socialUser->getAvatar(),
            'provider' => $provider,
            'provider_id' => $providerId,
            'password' => bcrypt(Str::random(16)),
            'email_verified_at' => now(),
        ]);

        Auth::login($user, true);

        return $user;
    }
}