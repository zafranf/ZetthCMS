<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Site\Controller;
use App\Models\User;
use App\Models\UserOauth;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;

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

    use AuthenticatesUsers {
        login as loginTrait;
    }

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
            'page_title' => 'Akses Masuk',
            'current_url' => route('web.login'),
        ];

        /* Set SEO */
        $this->setSEO($data['page_title']);

        return view($this->getTemplate() . '.auth.login', $data);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $r
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $r)
    {
        /* save activity */
        $this->activityLog('<b>' . $r->input($this->username()) . '</b> mencoba masuk ke situs');

        $user = User::where('name', $r->{$this->username()})
            ->orWhere('email', $r->{$this->username()})
            ->with('oauths:user_id,driver')
            ->first();
        if ($user && !$user->password) {
            $drivers = [];
            foreach ($user->oauths as $oauth) {
                $drivers[] = $oauth->driver;
            }

            return redirect(route('web.login'))->withInput()->with('oauths', $drivers);
        }

        return $this->loginTrait($r);
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
        request()->merge([$field => $value]);

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
        /* clear session * attempts */
        $r->session()->regenerate();
        $this->clearLoginAttempts($r);

        return $this->authenticated($r, $this->guard()->user()) ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $r
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $r, $user)
    {
        if ($user->status != "active") {
            Auth::logout();

            return redirect(route('web.login'))->withInput()->with('verified', false);
        }

        /* set redirect from next input */
        $this->redirectTo = $r->input('next');

        /* set redirect for user first login */
        if ($user->is_first_login == "yes") {
            $this->redirectTo = route('web.profile.edit');
        }

        /* save activity */
        $this->activityLog('[~name] masuk ke situs');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $r
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $r)
    {
        /* set redirect */
        $redirect = '/';

        /* set first login 0 */
        $user = app('user');
        $user->is_first_login = "no";
        $user->save();

        /* save activity */
        $this->activityLog('[~name] keluar dari situs');

        /* clear session */
        $this->guard()->logout();
        $r->session()->invalidate();

        return redirect($redirect);
    }

    /**
     * Redirect the user to the prodiver's authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $r, $driver)
    {
        /* save activity */
        $this->activityLog('[~name] mencoba masuk menggunakan <b>' . $driver . '</b>');

        if ($driver == 'google') {
            $scopes = [
                'https://www.googleapis.com/auth/plus.me',
                'https://www.googleapis.com/auth/plus.login',
            ];
        } else if ($driver == 'facebook') {
            $scopes = [
                'public_profile', 'email',
            ];
        } else if ($driver == 'magiclink') {
            $email = $r->input('email');
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->with('magiclink', false);
            }

            /* create user */
            $user = User::firstOrCreate([
                'email' => $email,
                'site_id' => app('site')->id,
            ]);

            /* save additional info */
            if ($user->wasRecentlyCreated) {
                $user->fullname = $email;
                $user->save();

                /* generate default user name */
                $user = $this->generateUsername($user);

                /* save detail */
                $user->detail()->create([
                    'user_id' => $user->id,
                    'site_id' => $user->site_id,
                ]);
            }

            /* create verification */
            $user->verify()->create([
                'user_id' => $user->id,
                'code' => md5($user->email . uniqid() . strtotime('now') . env('APP_KEY')),
                'expired_at' => now()->addDay(),
                'site_id' => $user->site_id,
            ]);

            /* set data parameter */
            $data = [
                'view' => $this->getTemplate() . '.emails.magiclink',
                'name' => $user->fullname,
                'email' => $user->email,
                'code' => $user->verify->code,
            ];

            /* send mail */
            \Mail::to($user->email)->queue(new \App\Mail\MagicLink($data));

            return redirect()->back()->with('magiclink', true);
        }

        return Socialite::driver($driver)->scopes($scopes)->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $r, $driver)
    {
        try {
            /* get user */
            if ($driver == 'magiclink') {
                $verify = \App\Models\UserVerification::where('code', $r->input('code'))->with('user:id,name,email,fullname,image')->first();
                if (!$verify) {
                    return redirect(route('web.login'))->with('magiclink_login', false);
                }

                /* check expire */
                $expired_at = $verify->expired_at;
                $expired = now()->greaterThanOrEqualTo($expired_at);

                /* check expired */
                if ($expired) {
                    return redirect(route('web.login'))->with('magiclink_login', false);
                }

                /* remove verify code */
                if (is_null($verify->verified_at)) {
                    $verify->delete();
                }

                /* get user */
                $oauthUser = $verify->user;
                if (!$oauthUser) {
                    return redirect(route('web.login'))->with('magiclink_login', false);
                }
            } else {
                $oauthUser = Socialite::driver($driver)->user();
            }

            /* find or create user and do login */
            $user = $this->findOrCreateUser($oauthUser, $driver);
            $user = Auth::loginUsingId($user->id);

            /* set redirect */
            if ($user->is_first_login == "yes") {
                $this->redirectTo = route('web.profile.edit');
            }

            /* save activity */
            $this->activityLog('[~name] masuk menggunakan <b>' . $driver . '</b>');

            return redirect($this->redirectTo);
        } catch (\Exception $e) {
            $this->errorLog($e);
            return redirect(route('web.login'))->with('failed', 'Gagal masuk menggunakan <b>' . $driver . '</b>');
        }
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $driver Social auth driver
     * @return  User
     */
    public function findOrCreateUser($oauthUser, $driver)
    {
        /* save user */
        $user = User::firstOrCreate([
            'email' => $oauthUser->email,
            'site_id' => app('site')->id,
        ], [
            'fullname' => $oauthUser->name,
            'email' => $oauthUser->email,
            'status' => 'active',
        ]);

        /* save additional info */
        if ($user->wasRecentlyCreated) {
            /* generate default user name */
            $user = $this->generateUsername($user);

            /* save detail */
            $user->detail()->create([
                'user_id' => $user->id,
                'site_id' => $user->site_id,
            ]);

            /* save image */
            if ($oauthUser->avatar) {
                $file = $oauthUser->avatar;
                $name = \Str::slug($user->name) . '.jpg';

                if ($this->uploadImage($file, '/assets/images/users/', $name)) {
                    $user->image = $name;
                    $user->save();
                }
            }
        }

        /* save user driver */
        UserOauth::firstOrCreate([
            'user_id' => $user->id,
            'driver' => $driver,
            'site_id' => $user->site_id,
        ], [
            'driver_uid' => $oauthUser->id,
            'user_id' => $user->id,
            'raw_data' => json_encode($oauthUser),
        ]);

        return $user;
    }
}
