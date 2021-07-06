<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:25',
            // 'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8|max:255',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'name' => $request->name,
            'phone' => $request->phone,
            "img" => "profile1.png",
            // 'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Default Role Guest With Not Have Any Permissions To Fix Users Table =======================
        $user->syncRoles(User::R_GUEST);

        return redirect()->route('login')->with('status', 'تم تسجيل الحساب وهو الان قيد المراجعة, عند التفعيل سيتم التواصل معك. شكرا لك :)');
    }
}