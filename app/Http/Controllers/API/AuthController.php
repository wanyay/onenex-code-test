<?php


namespace App\Http\Controllers\API;


use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $user =  Auth::user();
            $token = $user->createToken('accessToken')->accessToken;
            return $this->sendResponse([
                "name" => $user->name,
                "email" => $user->email,
                "token" => $token
            ], Response::HTTP_OK);
        }
        return $this->sendError("Unauthorized", Response::HTTP_UNAUTHORIZED);
    }
}
