<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function change_password(Request $reqest, User $user ){
        $reqest->validate([
            'password' => ['required'],
            'password_confirmation' => ['required', 'same:password']
        ]);

        $user->update([
            'password' => Hash::make($reqest->password)
        ]);
        return redirect()->route('users.index')->with('message', 'Password Updated!');
    }
}
