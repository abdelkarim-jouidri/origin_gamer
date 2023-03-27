<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EditProfileController extends Controller
{
    

    public function edit(Request $request, User $user){
        $fields = $request->validate([
            'name'=>'nullable|min:3',
            'email'=>'nullable|email|unique:users,email,'.$user->id,
            'password'=>'nullable|min:5',
            'role_id'=>'nullable|numeric'
        ]);

        if($request->password){
            $fields['password'] = Hash::make($request->password);
        }


        $user->update($fields);
        return response([
            'message'=>'successfully updated',
            'new credentials '=>$user
        ]);
    }
}
