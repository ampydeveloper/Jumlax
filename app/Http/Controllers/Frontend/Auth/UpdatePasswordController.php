<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Http\Requests\Frontend\User\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\users;

/**
 * Class UpdatePasswordController.
 */
class UpdatePasswordController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ChangePasswordController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UpdatePasswordRequest $request
     *
     * @throws \App\Exceptions\GeneralException
     * @return mixed
     */
    public function update(UpdatePasswordRequest $request)
    {
        dd($request); 
        $this->userRepository->updatePassword($request->only('old_password', 'password'));

        return redirect()->route('frontend.user.account')->withFlashSuccess(__('strings.frontend.user.password_updated'));
    }
    
    public function changePassword(Request $request){
        
        if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
            // The passwords matches
            return response()->json(['status' => false, 'message' => "Your current password does not matches with the password you provided. Please try again."]); 
        }

        if(strcmp($request->get('old_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
           return response()->json(["status" => false,"message" => "New Password cannot be same as your current password. Please choose a different password."]);
        }

        if($request->new_password != $request->confirm_password){
           return response()->json(["status" => false,"message" => "Conrirm password not match. Please choose a different password."]);
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();
        return response()->json(["status" => true,"message" => "Password changed successfully"]);

    }
}
