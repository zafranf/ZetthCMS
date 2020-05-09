<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index(Request $r, $type)
    {
        $data = [
            'page_title' => 'Verifikasi ' . ucfirst($type),
            'current_url' => route('web.verify', ['type' => $type]),
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        /* check code */
        if ($r->input('code')) {
            $r->merge([
                'type' => $type,
                'code' => $r->input('code'),
            ]);

            return $this->verify($r);
        }

        /* handle type */
        if ($type == config('path.verification_resend')) {
            $type = 'resend';
        }

        return view($this->getTemplate() . '.auth.verify_' . $type, $data);
    }

    public function verify(Request $r)
    {
        $this->validate($r, [
            'code' => ['required', 'string'],
        ]);

        if ($r->input('type') == 'email') {
            $verify = \App\Models\UserVerification::where('code', $r->input('code'))->with('user')->first();
            if ($verify) {
                $user = $verify->user;

                /* check expire */
                $expired_at = $verify->expired_at;
                $expired = now()->greaterThanOrEqualTo($expired_at);

                /* check expired */
                if ($expired) {
                    return redirect(route('web.verify', ['type' => 'email']))->with('success', false);
                }

                /* set verified */
                if (is_null($verify->verified_at)) {
                    $verify->verified_at = now();
                    $verify->save();

                    /* set status */
                    $user->status = 'active';
                    $user->save();
                } else if (!is_null($verify->verified_at)) {
                    return redirect(route('web.login'))->with('already_verified', true);
                }

                /* send mail */
                \Mail::to($user->email)->queue(new \App\Mail\Verified($user));

                return redirect(route('web.login'))->with('verified', true);
            }

            return redirect(route('web.verify', ['type' => 'email']))->with('success', false);
        }
    }

    public function resend(Request $r)
    {
        /* Check validation */
        $this->validate($r, [
            'email' => ['required', 'email'],
        ]);

        /* check user */
        $user = \App\Models\User::where('email', _encrypt($r->input('email')))->with('verify')->first();
        if ($user) {
            if (!$user->password) {
                $drivers = [];
                foreach ($user->oauths as $oauth) {
                    $drivers[] = $oauth->driver;
                }

                return redirect(route('web.verify', ['type' => config('path.verification_resend')]))->withInput()->with('oauths', $drivers);
            }

            /* check verify */
            $verify = $user->verify;
            if (!is_null($verify->verified_at)) {
                return redirect(route('web.login'))->with('already_verified', true);
            }

            /* update verify code */
            $verify->code = md5($user->email . uniqid() . strtotime('now') . env('APP_KEY'));
            $verify->save();

            /* send mail */
            \Mail::to($user->email)->queue(new \App\Mail\VerifyResend($user));
        }

        return redirect(route('web.verify', ['type' => 'email']))->with('resend', $user ? true : false);
    }
}
