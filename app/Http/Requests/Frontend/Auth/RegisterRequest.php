<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class RegisterRequest.
 */
class RegisterRequest extends FormRequest {

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
                'organization_name' => ['required', 'string', 'max:191'],
                'representative_name' => ['required', 'string', 'max:191'],
                'organization_email' => ['required', 'string', 'email', 'max:191', 'unique:users,email'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'g-recaptcha-response' => ['required_if:captcha_status,true', 'captcha'],
            ];
        } 
        else if ($request->charter_name != null) {
            return [
                'first_name' => ['required', 'string', 'max:191'],
                'last_name' => ['required', 'string', 'max:191'],
                'charter_name' => ['required', 'string', 'max:191'],
                'country' => ['required', 'string', 'max:191'],
                'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'g-recaptcha-response' => ['required_if:captcha_status,true', 'captcha'],
            ];
        }
        else {
            return [
                'first_name' => ['required', 'string', 'max:191'],
                'last_name' => ['required', 'string', 'max:191'],
                'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'g-recaptcha-response' => ['required_if:captcha_status,true', 'captcha'],
            ];
        }
    }

    /**
     * @return array
     */
    public function messages() {
        return [
            'g-recaptcha-response.required_if' => __('validation.required', ['attribute' => 'captcha']),
            'organization_email.unique' => 'This email has already been used.',
        ];
    }

}
