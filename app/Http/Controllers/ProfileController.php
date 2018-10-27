<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $this->profileDataValidation($request);
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->current_password)) {
            $current_password = $request->current_password;
            if(!Hash::check($current_password,auth()->user()->getAuthPassword())) {
                return back()->with('wrong_password', 'invalid password');
            }
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return back()->with('success', 'Your profile information has been updated successfully!');
    }

    private function profileDataValidation($request)
    {
        $password_validation = !is_null($request->current_password) ? 'required' : '';
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
            'password' => 'nullable|min:6|confirmed|'.$password_validation
        ];
        return $this->validate($request, $rules);
    }
}
