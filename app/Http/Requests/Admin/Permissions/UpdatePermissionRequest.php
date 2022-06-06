<?php

namespace App\Http\Requests\Admin\Permissions;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
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
        $permission_id = $this->permission->id;
        return [
            'name' => ['min:3', "unique:permissions,name,$permission_id"]
        ];
    }
}
