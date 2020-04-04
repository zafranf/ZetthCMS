<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Site\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $data = [
            'page_title' => 'Daftar Baru',
            'current_url' => route('web.register'),
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.auth.register', $data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $r
     * @return \Illuminate\Http\Response
     */
    public function register(Request $r)
    {
        /* remove dots from email */
        $emailex = explode("@", $r->input('email'));
        $email_name = str_replace(".", "", $emailex[0]);
        $email = $email_name . '@' . $emailex[1];
        $r->merge(['email' => $email]);

        /* validate */
        $this->validator($r->all())->validate();

        /* create new user */
        $user = $this->create($r->all());

        /* login to log activity */
        $this->guard()->login($user);

        /* save activity */
        $this->activityLog('[~name] daftar ke situs');

        /* clear session */
        $this->guard()->logout();
        $r->session()->invalidate();

        return $this->registered($r, $user) ?: redirect($this->redirectPath());
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
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
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
            'name' => $data['email'],
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verify_code' => md5($data['email'] . uniqid() . strtotime('now') . env('APP_KEY')),
            'verify_code_expire' => now()->addDay(),
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $r
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $r, $user)
    {
        /* generate default username */
        $this->generateUsername($user);

        /* send mail */
        $this->sendMail([
            'view' => $this->getTemplate() . '.emails.verify',
            'data' => [
                'name' => $user->fullname,
                'email' => $user->email,
                'verify_code' => $user->verify_code,
            ],
            'from' => env('MAIL_USERNAME', 'no-reply@' . env('APP_DOMAIN')),
            'to' => $user->email,
            'subject' => '[' . env('APP_NAME') . '] Verifikasi akun',
        ]);

        return redirect(route('web.verify', ['type' => 'email']))->with('registered', true);
    }
}
