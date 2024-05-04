<?php

namespace App\Modules\Auth\Service;

use App\Models\Client;
use App\Models\Organization\Employee\Employee;
use App\Models\Otp;
use App\Models\User;
use App\Modules\Auth\Dto\GoogleLoginDto;
use App\Modules\Auth\Dto\LoginDto;
use App\Modules\Auth\Enum\UserType;
use App\Modules\BusinessDashboard\Employee\Dto\CreateEmployeeDto;
use App\Modules\Client\Dto\CreateClientDto;
use App\Modules\Client\Service\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Nette\Utils\Random;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function __construct(protected ClientService $clientService)
    {
    }

    public function login(LoginDto $dto): JsonResponse
    {
        $credentials = ['username' => $dto->username, 'password' => $dto->password];
        $guard = $dto->is_client === true ? UserType::CLIENT->value : UserType::EMPLOYEE->value;
        if (!$token = auth("$guard")->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized - Wrong User Type'], 401);
        }
        return $this->respondWithToken($token, $guard);
    }

    public function google(GoogleLoginDto $dto)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://accounts.google.com/o/oauth2/token', [
            'grant_type' => "authorization_code",
            'code' => $dto->code,
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri'=> env('GOOGLE_REDIRECT'),
        ]);

        $data = $response->json();

        if (!$data['access_token']) {
            return response()->json(['error' => 'Unauthorized - Wrong User Type'], 401);
        }

        $userData = Http::withHeaders([
            'Authorization' => 'Bearer ' . $data['access_token'],
        ])->get('https://www.googleapis.com/oauth2/v3/userinfo')->json();

        if ($dto->is_client) {
            $user = Client::query()->where('email', $userData['email'])->first();

            if (!$user) {
                $createClientDto = new CreateClientDto($userData);
                $user = $this->clientService->create($createClientDto);
            }
        } else {
            $user = Employee::query()->where('email', $userData['email'])->first();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized - Wrong User Type'], 401);
            }
        }

        $guard = $dto->is_client ? UserType::CLIENT->value : UserType::EMPLOYEE->value;
        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token, $guard);
    }

    public function logout($request): void
    {
        $token = JWTAuth::getToken();
//        $guard = $request->is_client === true ? UserType::CLIENT->value : UserType::EMPLOYEE->value;
        JWTAuth::invalidate($token);
//        auth("$guard")->logout();
    }

    public function refresh($request)
    {
        $token = JWTAuth::getToken();
        $guard = $request->is_client ? UserType::CLIENT->value : UserType::EMPLOYEE->value;
        return $this->respondWithToken(auth($guard)->refresh($token), $guard);
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
