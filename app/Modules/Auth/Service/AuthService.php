<?php

namespace App\Modules\Auth\Service;

use App\Models\Client;
use App\Models\Organization\Employee\Employee;
use App\Models\Otp;
use App\Models\User;
use App\Modules\Auth\Dto\LoginDto;
use App\Modules\Auth\Enum\UserType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function google($dto)
    {
        if ($dto->is_client) {
            $user = Client::query()->where('email', $dto->email)->first();
            if (!$user) {
                $user = Client::create([
                    'email' => $dto->email,
                    'full_name' => $dto->name,
                    'username' => $dto->email,
                    'password' => Hash::make('password')
                ]);
            }
        } else {
            $user = User::query()->where('email', $dto->email)->first();

            if (!$user) {
                $user = User::query()->create([
                    'email' => $dto->email,
                    'username' => $dto->email,
                    'name' => $dto->name,
                    'password' => Hash::make('password')
                ])->first();
            }
        }

        $credentials = ['username' => $user->username, 'password' => $user->password];
        $guard = $dto->is_client ? UserType::CLIENT->value : UserType::EMPLOYEE->value;
        $token = auth("$guard")->attempt($credentials);

        return $this->respondWithToken($token, $guard);
    }

    public function logout($request): void
    {
        $guard = $request['is_client'] === true ? UserType::CLIENT->value : UserType::EMPLOYEE->value;
        auth("$guard")->logout();
    }

    public function refresh($request)
    {
        $guard = $request->is_client ? UserType::CLIENT->value : UserType::EMPLOYEE->value;
        return $this->respondWithToken(auth($guard)->refresh());
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
