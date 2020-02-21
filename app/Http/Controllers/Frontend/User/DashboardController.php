<?php

namespace App\Http\Controllers\Frontend\User;

use Auth;
use Hash;
use App\Models\Auth\User;
use Illuminate\Http\Request;
//use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.dashboard');
    }
    
    public function changePassword() {

        if(Auth::user()->first_time == TRUE) {
            return view('frontend.user.change_password');
        }
        return redirect()->route('frontend.user.dashboard');
    }
    
    public function changePasswordPost(Request $request) {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
//        dd($request->all());
        $user = Auth::user();
        if($user->first_time == TRUE) {
            if(User::where('id', $user->id)->update([
                'password' => Hash::make($request->password), 
                'password_changed_at' => now()->toDateTimeString(),
                'confirmed' => true,
                'first_time' => false])) {
                return redirect()->route('frontend.user.dashboard');
            }
        }
        return redirect()->back()->withFlashDanger('Password is not updated. Please try it again');
    }
}
