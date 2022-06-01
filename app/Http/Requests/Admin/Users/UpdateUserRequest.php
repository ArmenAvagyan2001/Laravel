<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user_id = $this->route('user')->id;
        return [
            'name' => ['min:2'],
            'email' => ['email', "unique:users,email,$user_id"],
            'password' => ['min:6'],
            'password_confirmation' => ['same:password'],
        ];
    }
}
