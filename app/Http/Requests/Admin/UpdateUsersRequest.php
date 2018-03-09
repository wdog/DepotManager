<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsersRequest extends FormRequest
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
        $id = $this->route( 'user' )->id;
        return [
            'name' => 'required',
            'email'    => [
                'required',
                'email',
                Rule::unique( 'users' )->where( 'id', '<>', $id ),
            ],
            'roles'    => 'required',
            'group_id' => 'required',
        ];
    }
}
