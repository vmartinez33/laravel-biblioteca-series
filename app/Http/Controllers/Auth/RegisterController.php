<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $countries = ['España', 'Francia', 'Portugal', 'Alemania', 'Italia'];
        return Validator::make($data, [
            'name' => ['required', 'alpha', 'between:2,20'],
            'surnames' => ['required', 'alpha', 'between:2,40'], // NO ADMITE ESPACIOS EN BLANCO!!!
            'dni' => ['required', 'regex:/(^[0-9]{8})+[A-Z]{1}$/'],
            'phone' => ['nullable', 'regex:/^[+]$[0-9]+$|[0-9]+$/', 'between:9,12'],
            'country' => ['nullable', 'alpha', Rule::in($countries)],
            'iban' => ['required', 'regex:/^ES+[0-9]{22}$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:10', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%\+*?&#.$()\-_^\[\],])[A-Za-z\d$@$!%\+*?&#.$()\-_^\[\],]{0,}$/', 'confirmed'],
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
