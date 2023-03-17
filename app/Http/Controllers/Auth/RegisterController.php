<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function createUser(Request $request)
    {
        $request->validate([
    		'name' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
    	],[
    		'name.required' => 'This field is required',
    		'email.required' => 'This field is required',
            'email.email' => 'This must be an email',
            'email.unique' => 'This email is used before',
            'password.required' => 'This field is required',
            'password.min' => 'Password must be 8 characters or more',
            'password.confirmed' => 'Passwords must match',
            'password_confirmation.required' => 'This field is required',
            'password_confirmation.min' => 'Password confirmation must be 8 characters or more',
        ]);

         User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $notification = array(
			'message' => 'User created successfully, Please check your email to activate',
			'alert-type' => 'success'
		);

		return redirect()->route('login')->with($notification);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }
}
