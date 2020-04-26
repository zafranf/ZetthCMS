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
        if ($r->input('kode')) {
            $r->merge([
                'type' => $type,
                'code' => $r->input('kode'),
            ]);

            return $this->verify($r);
        }

        /* handle type */
        if ($type == 'kirim-ulang') {
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
            $verify = \App\Models\UserVerification::where('verify_code', $r->input('code'))->with('user')->first();
            $user = $verify->user;
            if ($user) {
                /* check expire */
                $expire_at = $verify->verify_code_expire;
                $expired = now()->greaterThanOrEqualTo($expire_at);

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

                /* set data parameter */
                $data = [
                    'view' => $this->getTemplate() . '.emails.verified',
                    'name' => $user->fullname,
                    'email' => $user->email,
                    'verify_code' => $verify->verify_code,
                ];

                /* send mail */
                \Mail::to($user->email)->queue(new \App\Mail\Verified($data));

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
        $user = \App\Models\User::where('email', $r->input('email'))->with('verify')->first();
        if ($user) {
            if (!$user->password) {
                $drivers = [];
                foreach ($user->oauths as $oauth) {
                    $drivers[] = $oauth->driver;
                }

                return redirect(route('web.verify', ['type' => 'kirim-ulang']))->withInput()->with('oauths', $drivers);
            }

            /* check verify */
            $verify = $user->verify;
            if (!is_null($verify->verified_at)) {
                return redirect(route('web.login'))->with('already_verified', true);
            }

            /* update verify code */
            $verify->verify_code = md5($user->email . uniqid() . strtotime('now') . env('APP_KEY'));
            $verify->save();

            /* set data parameter */
            $data = [
                'view' => $this->getTemplate() . '.emails.verify',
                'name' => $user->fullname,
                'email' => $user->email,
                'verify_code' => $verify->verify_code,
            ];

            /* send mail */
            \Mail::to($user->email)->queue(new \App\Mail\VerifyResend($data));
        }

        return redirect(route('web.verify', ['type' => 'email']))->with('resend', $user ? true : false);
    }
}
