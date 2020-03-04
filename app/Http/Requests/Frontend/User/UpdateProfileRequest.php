<?php

namespace App\Http\Requests\Frontend\User;

use Illuminate\Validation\Rule;
use App\Helpers\Auth\SocialiteHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class UpdateProfileRequest.
 */
class UpdateProfileRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request) {
        
        if ($request->organization_name != null && $request->representative_name != null) {
            return [
                'organization_name' => ['required', 'max:191'],
                'representative_name' => ['required', 'max:191'],
                'email' => ['sometimes', 'required', 'email', 'max:191'],
                'avatar_type' => ['required', 'max:191', Rule::in(array_merge(['gravatar', 'storage'], (new SocialiteHelper)->getAcceptedProviders()))],
                'avatar_location' => ['sometimes', 'image', 'max:191'],
            ];
        } else {
            return [
                'first_name' => ['required', 'max:191'],
                'last_name' => ['required', 'max:191'],
                'email' => ['sometimes', 'required', 'email', 'max:191'],
                'avatar_type' => ['required', 'max:191', Rule::in(array_merge(['gravatar', 'storage'], (new SocialiteHelper)->getAcceptedProviders()))],
                'avatar_location' => ['sometimes', 'image', 'max:191'],
            ];
        }
    }

}
