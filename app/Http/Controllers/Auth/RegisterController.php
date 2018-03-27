<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Models\Users\User;
use App\Http\Requests\Users\Store;
use Illuminate\Auth\Events\Registered;
use App\Jobs\SendVerificationEmail;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'email_token' => base64_encode($data['email'])
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Store $request)
    {
        event(new Registered($user = $this->create($request->all())));
        $user->assignRole($request->user_type);

        dispatch(new SendVerificationEmail($user));

        $this->guard()->login($user);

        return response()->json([
            'session' => 'Profile Created',
            'user' => $user
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param string $token
     * @param \Illuminate\Http\Request $requets
     * @return \Illuminate\Http\Response
     */
    public function verify($token, Request $request)
    {
        $user = User::where('email_token', $token)->first();
        $user->verified = 1;
        if($user->save()) {
            $request->session()->flash('success', 'Nicely done! Your email has been confirmed.');
            return view('home');
        }
    }
}
