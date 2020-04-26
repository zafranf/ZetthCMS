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
        if (app('user')->is_first_login == "yes") {
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
    public function redirectToProvider($driver)
    {
        if ($driver == 'google') {
            $scopes = [
                'https://www.googleapis.com/auth/plus.me',
                'https://www.googleapis.com/auth/plus.login',
            ];
        } else if ($driver == 'facebook') {
            $scopes = [
                'public_profile', 'email',
            ];
        }

        return Socialite::driver($driver)->scopes($scopes)->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($driver)
    {
        try {
            /* get user */
            $user = Socialite::driver($driver)->user();

            /* find or create user and do login */
            $authUser = $this->findOrCreateUser($user, $driver);
            Auth::loginUsingId($authUser->id);

            /* set redirect */
            if (app('user')->is_first_login == "yes") {
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

    public function loginByEmail(Request $r)
    {
        try {
            $email = trim($r->input('email'));
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("Masukkan alamat email dengan benar", 1);
            }

            /* save activity */
            $this->activityLog('[~email] meminta akses via tautan ajaib');

            $type = 'success';
            $message = 'Berhasil! Silakan cek email anda dan klik tautan ajaib yang kami berikan untuk akses masuk.';
        } catch (\Exception $e) {
            $this->errorLog($e);
            $type = 'failed';
            $message = $e->getMessage();
        }

        return redirect(route('web.login'))->with($type, $message);
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
        ], [
            'name' => $oauthUser->email,
            'fullname' => $oauthUser->name,
            'email' => $oauthUser->email,
            'status' => 'active',
        ]);

        /* generate default user name */
        if ($user->wasRecentlyCreated) {
            $user = $this->generateUsername($user);

            /* save detail */
            $user->detail()->create([
                'user_id' => $user->id,
            ]);

            /* save image */
            if ($oauthUser->avatar) {
                $file = $oauthUser->avatar;
                $name = str_slug($user->name) . '.jpg';

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
        ], [
            'driver_uid' => $oauthUser->id,
            'user_id' => $user->id,
            'raw_data' => json_encode($oauthUser),
        ]);

        return $user;
    }
}
