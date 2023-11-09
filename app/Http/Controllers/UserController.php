<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function refreshApiKey()
    {
        $newApiKey = User::generateApiToken();
        /** @var User $user */
        $user = Auth::user();
        $user->update(['api_token' => $newApiKey]);

        return response(['data' => ['api_token' => $newApiKey]]);
    }
}
