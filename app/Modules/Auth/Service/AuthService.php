<?php

namespace App\Modules\Auth\Service;

use App\Models\Organization\Employee\Employee;
use App\Models\Otp;
use App\Modules\Auth\Dto\LoginDto;
use App\Modules\Auth\Enum\UserType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(LoginDto $dto): JsonResponse
    {
        $credentials = ['username' => $dto->username, 'password' => $dto->password];
        $guard = $dto->is_client === true ? UserType::CLIENT->value : UserType::EMPLOYEE->value;
        if (!$token = auth("$guard")->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized - Wrong User Type'], 401);
        }
        return $this->respondWithToken($token, $guard);
    }

    public function logout($request): void
    {
        $guard = $request['is_client'] === true ? UserType::CLIENT->value : UserType::EMPLOYEE->value;
        auth("$guard")->logout();
    }

    protected function respondWithToken($token, $guard): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard($guard)->factory()->getTTL() * 60
        ]);
    }

    public function generateOtp(string $phone)
    {
        $code = rand(0, 999999);
        $otp = new Otp();
        $otp->code = $code;
        $otp->save();
        return $otp->id;
    }
}
