<?php

namespace App\Http\Controllers;

use App\Adapter\WunderfleetPayment;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    public function register(UserRegistrationRequest $userRegistrationRequest, User $user, WunderfleetPayment $wunderfleetPayment): Response
    {
        $user->register($userRegistrationRequest, $wunderfleetPayment);

        return response([]);
    }
}
