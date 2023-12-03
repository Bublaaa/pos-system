<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    // Position options
    const POSITION_OPTIONS = [
        'owner' => 'Owner',
        'employee' => 'Employee',
        'headbar' => 'Head Bar',
    ];
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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function registered(Request $request, $user)
    {
        event(new Registered($user)); // Fire the Registered event
        return redirect()->intended($this->redirectPath())->with('success', 'User registered successfully.');
    }

    public function store(Request $request)
    {
        // $profileImagePath = '';
        // if ($request->hasFile('profile_image')) {
        //      $profileImagePath = $request->profile_image = $request->file('profile_image')->store('images/' . $request->profile_image, 'public');
        // } 
        $this->validator($request->all())->validate();
        
        $requestArray = $request->all();
        $requestArray += ['image' => $profileImagePath];

        $user = $this->create($requestArray);

        return redirect()->intended($this->redirectPath())->with('success', 'User registered successfully.');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255' ,'unique:users'],
            'position' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable'],
            'phone_number' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'basic_salary' => ['required', 'integer', 'min:1'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
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
        // dd($data);
        return User::create([
            'name' => ucwords($data['name']),
            'position' => $data['position'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
            'address' => ucwords($data['address']),
            'basic_salary' => $data['basic_salary'],
            'bank_name' => strtoupper($data['bank_name']),
            'account_number' => $data['account_number'],
        ]);
    }
}