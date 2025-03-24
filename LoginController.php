<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LoginController
{
    public function Login(Request $request){

        if($request->isMethod('get')){
            return view('login');
        }

        $email = $request->input('email');
        $password =$request->input('password');

        DB::table('login_d_b_s') -> updateOrInsert(
            ['Email' => $email],
            [
                'Email' => $email,
                'Password' => bcrypt($password)
            ]
        );

        return redirect('/Panel');

    }

}
