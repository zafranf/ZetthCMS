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
        $user = \App\Models\User::active()->where('email', _encrypt($r->input('email')))->first();
        if ($user) {
            if (!$user->password) {
                $drivers = [];
                foreach ($user->oauths as $oauth) {
                    $drivers[] = $oauth->driver;
                }

                return redirect(route('web.forgot.password'))->withInput()->with('oauths', $drivers);
            }

            /* Create reset password token */
            $reset = \App\Models\PasswordReset::updateOrCreate([
                'email' => _encrypt($user->email),
                'site_id' => app('site')->id,
            ], [
                'token' => md5($user->email . uniqid() . strtotime('now') . env('APP_KEY')),
                'created_at' => now(),
            ]);

            /* send mail */
            \Mail::to($user->email)->queue(new \App\Mail\ForgotPassword($user, $reset));

            return redirect(route('web.reset.password'))->with('request_reset', true);
        }

        return redirect(route('web.forgot.password'))->with('success', $user ? true : false);
    }
}
