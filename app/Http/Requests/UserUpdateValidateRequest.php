<?php

namespace sgcom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateValidateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $id = auth()->user()->id;
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,{$id},id',
            'password' => 'min:6|max:20',
            'image' => 'image',
        ];
    }
}
