<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
        $id = $this->route( 'project' )->id;
        return [
            'group_id' => 'required',

            'name' => [
                'max:25',
                'required',
                Rule::unique( 'projects' )->where( 'id', '<>', $id ),
            ],
        ];
    }
}
