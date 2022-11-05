<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Rules\AlphaSpaces;
use App\Rules\Dni;
use App\Rules\Iban;
use App\Rules\PasswordFormat;
use App\Rules\PhoneNumber;

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
        $countries = ['España', 'Francia', 'Portugal', 'Alemania', 'Italia'];
        return Validator::make($data, [
            'name' => ['required', 'alpha', 'between:2,20'],
            'surnames' => ['required', 'between:2,40', new AlphaSpaces],
            'dni' => ['required', new Dni],
            'phone' => ['nullable', 'between:9,12', new PhoneNumber],
            'country' => ['nullable', 'alpha', Rule::in($countries)],
            'iban' => ['required', new Iban],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:10', 'confirmed', new PasswordFormat],
            'about' => ['nullable', 'between:20,250'],
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
            'name' => $data['name'],
            'surnames' => $data['surnames'],
            'dni' => $data['dni'],
            'phone' => $data['phone'],
            'country' => $data['country'],
            'iban' => $data['iban'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'about' => $data['about'],
        ]);
    }
}
