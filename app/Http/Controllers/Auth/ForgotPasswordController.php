<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Site\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */

    use SendsPasswordResetEmails;

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
            'page_title' => 'Lupa Sandi',
            'current_url' => route('web.forgot.password'),
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.auth.forgot_password', $data);
    }

    public function send(Request $r)
    {
        /* Check validation */
        $this->validate($r, [
            'email' => ['required', 'email'],
        ]);

        /* check user */
        $user = \App\Models\User::active()->where('email', $r->input('email'))->first();
        if ($user) {
            if (!$user->password) {
                $drivers = [];
                foreach ($user->oauths as $oauth) {
                    $drivers[] = $oauth->driver;
                }

                return redirect(route('web.forgot.password'))->withInput()->with('oauths', $drivers);
            }

            /* Create reset password token */
            $password = \App\Models\PasswordReset::updateOrCreate([
                'email' => $r->input('email'),
            ], [
                'token' => md5($r->input('email') . uniqid() . strtotime('now') . env('APP_KEY')),
            ]);
            /* send mail */
            $this->sendMail([
                'view' => $this->getTemplate() . '.emails.forgot_password',
                'data' => [
                    'name' => $user->fullname,
                    'email' => $user->email,
                    'code' => $password->token,
                ],
                'from' => env('MAIL_USERNAME', 'no-reply@' . env('APP_DOMAIN')),
                'to' => $user->email,
                'subject' => '[' . env('APP_NAME') . '] Permintaan ubah sandi',
            ]);
        }

        return redirect(route('web.forgot.password'))->with('success', $user ? true : false);
    }
}
