<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
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
        $id = $this->route( 'item' )->id;
        return [
            'code' => [
                'required',
                Rule::unique( 'items' )->where( 'id', '<>', $id ),
            ],
            'name' => 'required',
            'um'   => 'required',
        ];
    }
}
