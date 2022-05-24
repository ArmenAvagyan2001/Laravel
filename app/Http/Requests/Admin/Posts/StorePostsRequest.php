<?php

namespace App\Http\Requests\Admin\Posts;

use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePostsRequest extends FormRequest
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
        return [
            'name' => ['required', 'min:3'],
            'subject' => ['required', 'min:3'],
            'image' => ['required', 'image:jpg,jpeg,png,bmp,gif,svg']
        ];
    }
}
