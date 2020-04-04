<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Site\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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

    public function index(Request $r)
    {
        $data = [
            'page_title' => 'Ubah Sandi',
            'current_url' => route('web.reset.password'),
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        /* check code expiration */
        if ($r->input('kode')) {
            $reset = \App\Models\PasswordReset::where('token', $r->input('kode'))->first();
            if ($reset) {
                $expire_at = $reset->created_at->addDay();
                $expired = now()->greaterThanOrEqualTo($expire_at);

                /* check expired */
                if ($expired) {
                    return redirect(route('web.forgot.password'))->with('expired', true);
                }
            } else {
                return redirect(route('web.forgot.password'))->with('expired', true);
            }
        } else {
            return redirect(route('web.forgot.password'))->with('expired', true);
        }

        return view($this->getTemplate() . '.auth.reset_password', $data);
    }

    public function store(Request $r)
    {
        /* Check validation */
        $this->validate($r, [
            'code' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        /* check user */
        $reset = \App\Models\PasswordReset::where('token', $r->input('code'))->with('user')->first();
        if ($reset && $reset->user) {
            /* set new password */
            $user = $reset->user;
            $user->password = Hash::make($r->input('password'));
            $user->save();

            /* remove reset */
            $reset->delete();

            /* send mail */
            $this->sendMail([
                'view' => $this->getTemplate() . '.emails.reset_password',
                'data' => [
                    'name' => $user->fullname,
                    'email' => $user->email,
                ],
                'from' => env('MAIL_USERNAME', 'no-reply@' . env('APP_DOMAIN')),
                'to' => $user->email,
                'subject' => '[' . env('APP_NAME') . '] Ubah sandi berhasil!',
            ]);
        }

        return redirect(route('web.login'))->with('password_changed', isset($user) ? true : false);
    }
}
