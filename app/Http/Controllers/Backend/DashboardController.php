<?php

namespace App\Http\Controllers\Backend;

use Mail;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.dashboard');
    }
    
    public function inviteVendor() {
        return view('backend.inviteVendor');
    }
    
    public function inviteVendorPost(Request $request) {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
        ]);
        
        $userDetail = $request->all();
        $random = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        $password = substr(str_shuffle($random), 0, 8);
//        dd($password);
        $user = new User();
        $user->first_name = $userDetail['first_name'];
        $user->last_name = $userDetail['last_name'];
        $user->email = $userDetail['email'];
        $user->password = $password;
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->first_time = true;
        if ($user->save()) {
            $data = [
                'name' => $userDetail['first_name'],
                'email' => $userDetail['email'],
                'password' => $password,
                'url' => $_SERVER['HTTP_ORIGIN'] . '/login',
            ];
            
            Mail::send('backend.mail', $data, function($message) use($user) {
                $message->to($user->email, 'Jumlax')->subject
                        ('Invitation for becoming vendor with Jumlax');
                $message->from('xyz@gmail.com', 'Jumlax');
            });
        }
//        $user->save();
        dd($password);
        
    }
}
