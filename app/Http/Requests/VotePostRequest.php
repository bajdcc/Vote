<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VotePostRequest extends Request
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
        return [
            'choice' => 'required|alpha|max:1',
            'uid' => 'required|alpha_num|min:2|max:20',
        ];
    }
}
