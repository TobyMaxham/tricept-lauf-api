<?php

namespace App\Http\Controllers;

use App\LaufClient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AppAuthController
{
    public function getLogin()
    {
        if (auth()->user()) {
            return redirect('/');
        }

        return view('login');
    }

    public function getLogout()
    {
        if (auth()->user()) {
            auth()->logout();
        }

        return redirect('/');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        $username = $request->get('username');
        $password = $request->get('password');

        if (null != ($user = User::where('username', $username)->first())) {
            if (Hash::check($password, $user->password)) {
                auth()->login($user);
                return redirect('/');
            } else {
                return redirect()->back()->withErrors('Login Invalid');
            }
        }

        $client = new LaufClient();
        $response = $client->doLogin($username, $password);
        if (null == $response->data) {
            return redirect()->back()->withErrors('Login Invalid');
        }

        $token = $response->data;
        $profile = $client->getProfile($token);
        if (null == $profile || !isset($profile->data->username)) {
            return redirect()->back()->withErrors('Cant fetch your profile');
        }

        $user = User::createFromApp($username, $password, $profile->data->username, $token);
        auth()->login($user);

        return redirect('/');
    }
}
