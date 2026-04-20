<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAuthService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    protected SocialAuthService $socialAuthService;

    public function __construct(SocialAuthService $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

    public function redirect(string $provider): RedirectResponse
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect('/login')->with('error', 'Nhà cung cấp không hợp lệ.');
        }

        if ($provider === 'facebook') {
            return Socialite::driver('facebook')
                ->stateless()
                ->scopes(['public_profile'])
                ->redirect();
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect('/login')->with('error', 'Nhà cung cấp không hợp lệ.');
        }

        try {
            if ($provider === 'facebook') {
                $socialUser = Socialite::driver('facebook')
                    ->stateless()
                    ->user();
            } else {
                $socialUser = Socialite::driver('google')->user();
            }

            $this->socialAuthService->loginOrCreateUser($socialUser, $provider);

            return redirect('/dashboard')->with('success', 'Đăng nhập thành công!');
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Đăng nhập thất bại: ' . $e->getMessage());
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login')->with('success', 'Đăng xuất thành công.');
    }
}