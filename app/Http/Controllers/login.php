<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class login extends Controller
{
    function login(Request $request)
    {
        $credentials = [
            'email' => $request->email ,
            'password' => $request->password
        ];
        // dd ($credentials);
        if(Auth::attempt($credentials)){
            $type = user::where('email',$request->email)->first();
            if ($type['type'] == 0){
                return 'admin' ;
            }elseif ($type['type'] == 1){
                return 'techer';
            }elseif ($type['type'] == 2){
                return 'student';
            }else{
                return 'Error';
            }
        }else{
            return 'Error Login';
        }

    }
}
