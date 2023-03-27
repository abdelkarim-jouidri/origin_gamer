<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    //
    public function sendResetLink(Request $request){
        $email = $request->validate(['email'=>'required|email']);
        $status = Password::sendResetLink($email);

        return $status === Password::RESET_LINK_SENT
                    ?  response(['message'=>"Link successfully sent to $request->email"])
                    :  response(['message'=>'something went wrong']);
    }

    public function resetPassword(Request $request){
         $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5',
            'token'=>'required'
        ]);

        $status = Password::reset(
            $request->only('email','password','token'),
            function(User $user , string $password){
                $user->forceFill([
                    'password'=>Hash::make($password)
                ]);

                $user->save();
            }

        );

        return $status === Password::PASSWORD_RESET
                ? response(['message'=>'password reset successfully'])
                : response(['message'=>'something went wrong']);


    }
}
