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
            $user = \App\Models\User::where('verify_code', $r->input('code'))->first();
            if ($user) {
                /* check expire */
                $expire_at = $user->verify_code_expire;
                $expired = now()->greaterThanOrEqualTo($expire_at);

                /* check expired */
                if ($expired) {
                    return redirect(route('web.verify', ['type' => 'email']))->with('success', false);
                }

                /* set verified */
                if (!$user->verified_at) {
                    $user->verified_at = now();
                    $user->status = 1;
                    $user->save();
                }

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
        $user = \App\Models\User::active()->where('email', $r->input('email'))->first();
        if ($user) {
            if (!$user->password) {
                $drivers = [];
                foreach ($user->oauths as $oauth) {
                    $drivers[] = $oauth->driver;
                }

                return redirect(route('web.verify', ['type' => 'kirim-ulang']))->withInput()->with('oauths', $drivers);
            }

            /* update verify code */
            $user->verify_code = md5($user->email . uniqid() . strtotime('now') . env('APP_KEY'));
            $user->save();

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
                'subject' => '[' . env('APP_NAME') . '] Verifikasi akun (kirim ulang)',
            ]);
        }

        return redirect(route('web.verify', ['type' => 'email']))->with('resend', $user ? true : false);
    }
}
