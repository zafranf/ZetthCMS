<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        parent::__construct();
        $this->current_url = url('/login');
        $this->page_title = 'Masuk';
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $data = [
            'current_url' => $this->current_url,
            'page_title' => $this->page_title,
            'page_subtitle' => 'Masuk aplikasi',
        ];

        if ($this->isAdminPage) {
            $data['page_title'] = 'Masuk Halaman Admin';

            return view('admin.auth.login', $data);
        } else {
            return view('auth.login', $data);
        }
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        /* set variable */
        $field = 'name';
        $value = request()->get($field);

        /* check input email */
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        }

        /* merge request */
        request()->merge([
            $field => $value,
            'remember_me' => bool(request()->get('remember_me')),
        ]);
        // dd(request()->input());

        return $field;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $r
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $r)
    {
        $r->session()->regenerate();

        $this->clearLoginAttempts($r);

        /* log aktifitas */
        $this->activityLog('<b>' . \Auth::user()->fullname . '</b> masuk aplikasi');

        /* set redirect for user admin */
        if (\Auth::user()->is_admin) {
            if ($this->isAdminPage) {
                $this->redirectTo = '/dashboard';
            } else {
                $this->redirectTo = '/admin/dashboard';
            }
        }

        return $this->authenticated($r, $this->guard()->user())
        ?: redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $r
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $r)
    {
        $user = \Auth::user();
        \Cache::forget('cache-roleid-user' . $user->id);
        \Cache::forget('cache-menu-user' . $user->id);

        /* set redirect */
        $redirect = '/';
        if ($user->is_admin) {
            if ($this->isAdminPage) {
                $redirect = '/login';
            } else {
                $redirect = '/admin/login';
            }
        }

        /* log aktifitas */
        $this->activityLog('<b>' . $user->fullname . '</b> keluar dari aplikasi');

        $this->guard()->logout();

        $r->session()->invalidate();

        return redirect($redirect);
    }
}
