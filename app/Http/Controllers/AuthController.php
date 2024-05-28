<?php

namespace App\Http\Controllers;

use App\Modules\Auth\Dto\GoogleLoginDto;
use App\Modules\Auth\Dto\LoginDto;
use App\Modules\Auth\Dto\SetPhoneDto;
use App\Modules\Auth\Request\GoogleLoginRequest;
use App\Modules\Auth\Request\LoginRequest;
use App\Modules\Auth\Request\LogoutRequest;
use App\Modules\Auth\Request\RefreshRequest;
use App\Modules\Auth\Request\SetPhoneLoginRequest;
use App\Modules\Auth\Service\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $loginService)
    {
        $this->middleware(['jwt.auth'])->except('login', 'google', 'refresh', 'setPhone');
    }

    public function login(LoginRequest $request)
    {
        $loginDto = new LoginDto($request->validated());
        return $this->loginService->login($loginDto);
    }

    public function google(GoogleLoginRequest $request)
    {
        $googleLoginDto = new GoogleLoginDto($request->validated());
        return $this->loginService->google($googleLoginDto);
    }

    public function setPhone(SetPhoneLoginRequest $request)
    {
        $setPhoneDto = new SetPhoneDto($request);
        return $this->loginService->setPhone($setPhoneDto);
    }

    public function refresh(RefreshRequest $request)
    {
        return $this->loginService->refresh($request);
    }

    public function logout(LogoutRequest $request)
    {
        $this->loginService->logout($request->validated());
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getOtp(string $phone)
    {
        $otpId = $this->loginService->generateOtp($phone);
        return response()->json(['otpId' => $otpId]);
    }

    public function getProfile()
    {
        $user = auth()->user()->makeHidden('password');
        return response()->json($user);
    }
}
