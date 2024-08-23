<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'user_type' => 'required|in:patient,doctor,admin',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type'=>$request->user_type,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));


        Auth::login($user);

     if($user->user_type == 'patient')
     {
        return redirect(route('patients.create', absolute: false));

     }
     else if($user->user_type == 'doctor')
     {

        return redirect(route('doctors.create', absolute: false));
     }
     else
     {
        return redirect(route('dashboard', absolute: false));
     }



    }
}
