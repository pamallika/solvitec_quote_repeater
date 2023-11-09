<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use function App\Helpers\errResponse;
use function App\Helpers\okResponse;

class AuthController extends Controller
{
    public function registration(RegistrationRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['api_token'] = User::generateApiToken();
        User::firstOrCreate(['login' => $data['login']], $data);

        return okResponse($data);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (auth()->attempt($data)) {
            /** @var User $user */
            $user = User::where(['login' => $data['login']])->firstOrFail();

            return okResponse(['api_token' => $user->getApiToken()]);
        }

        return errResponse('HTTP_UNAUTHORIZED', ResponseAlias::HTTP_UNAUTHORIZED);
    }

}
