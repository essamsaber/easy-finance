<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProfileController
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = auth()->user();
        return view('profile.profile', compact('user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->profileDataValidation($request);
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->current_password)) {
            $current_password = $request->current_password;
            if($this->passwordMatched($current_password) === false) {
                return back()->with('wrong_password', 'invalid password');
            }
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return back()->with('success', 'Your profile information has been updated successfully!');
    }

    /**
     * @param $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
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


    /**
     * Determine if the current password that comes from the form is matched
     * with the password that exists in the database
     *
     * @param $current_password
     */
    private function passwordMatched($current_password)
    {
        Hash::check($current_password,auth()->user()->getAuthPassword());
    }
}
