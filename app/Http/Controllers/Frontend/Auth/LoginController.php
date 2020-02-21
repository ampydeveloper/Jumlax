<?php

namespace App\Http\Controllers\Frontend\Auth;

use Session;
use Illuminate\Http\Request;
use App\Helpers\Auth\AuthHelper;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Helpers\Auth\SocialiteHelper;
use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * Class LoginController.
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('frontend.auth.login')
            ->withSocialiteLinks((new SocialiteHelper)->getSocialLinks());
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return config('access.users.username');
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param         $user
     *
     * @throws GeneralException
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
//        dd($user->toArray());
        if($user->first_time == TRUE) {
            event(new UserLoggedIn($user));
            return redirect()->route('frontend.user.changePassword');
        }
        // Check to see if the users account is confirmed and active
        if (! $user->isConfirmed()) {
            auth()->logout();

            // If the user is pending (account approval is on)
            if ($user->isPending()) {
                throw new GeneralException(__('exceptions.frontend.auth.confirmation.pending'));
            }

            // Otherwise see if they want to resent the confirmation e-mail

            throw new GeneralException(__('exceptions.frontend.auth.confirmation.resend', ['url' => route('frontend.auth.account.confirm.resend', e($user->{$user->getUuidName()}))]));
        }

        if (! $user->isActive()) {
            auth()->logout();

            throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
        }

        event(new UserLoggedIn($user));

        if (config('access.users.single_login')) {
            auth()->logoutOtherDevices($request->password);
        }

        $token = uniqid();
        $tokenExists = \DB::connection('mysql_wp')->select('SELECT * FROM `single_signin_tokens` WHERE `email`="'.$request['email'].'"');
        if($tokenExists){
            \DB::connection('mysql_wp')->update('UPDATE `single_signin_tokens` SET `token` = "'.$token.'" WHERE `email` = "'.$request["email"].'"');
        }else{
            \DB::connection('mysql_wp')->insert('INSERT INTO `single_signin_tokens`(email, token) VALUES ("'.$request["email"].'","'.$token.'");');
        }
        
        if(!empty(session::get('passangerDetail'))) {
            if(!empty(session::get('charter'))) {
                // return redirect()->route('frontend.charterpaymentGet');
                return redirect(env("WP_URL") . 'laravel-user.php?action=login&email='.$request['email'].'&token='.$token.'&redirect='.route('frontend.charterpaymentGet'));
            }
            // return redirect()->route('frontend.paymentGet');
            return redirect(env("WP_URL") . 'laravel-user.php?action=login&email='.$request['email'].'&token='.$token.'&redirect='.route('frontend.paymentGet'));
        } else {
            // return redirect()->intended($this->redirectPath());
            return redirect(env("WP_URL") . 'laravel-user.php?action=login&email='.$request['email'].'&token='.$token.'&redirect='.$this->redirectPath());
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Remove the socialite session variable if exists
        if (app('session')->has(config('access.socialite_session_name'))) {
            app('session')->forget(config('access.socialite_session_name'));
        }

        // Remove any session data from backend
        resolve(AuthHelper::class)->flushTempSession();

        // Fire event, Log out user, Redirect
        event(new UserLoggedOut($request->user()));

        // Laravel specific logic
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect()->route('frontend.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutAs()
    {
        // If for some reason route is getting hit without someone already logged in
        if (! auth()->user()) {
            return redirect()->route('frontend.auth.login');
        }

        // If admin id is set, relogin
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            // Save admin id
            $admin_id = session()->get('admin_user_id');

            resolve(AuthHelper::class)->flushTempSession();

            // Re-login admin
            auth()->loginUsingId((int) $admin_id);

            // Redirect to backend user page
            return redirect()->route('admin.auth.user.index');
        }

        resolve(AuthHelper::class)->flushTempSession();

        auth()->logout();

        return redirect()->route('frontend.auth.login');
    }
}
