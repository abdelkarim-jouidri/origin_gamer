<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AssignRoleController extends Controller
{
    public function update(Request $request , User $user){
        $role = $request->validate([
            'role'=>'required|alpha'
        ]);
        $role = Role::whereLabel($role)->firstOrFail();
        $user->update(['role_id'=>$role->id]);
        return response()->json([
            'status' => 'success',
            'message' => 'Role updated successfully',
            'user' => $user,
          
        ]);
    }
}
