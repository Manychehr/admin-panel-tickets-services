<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExportRequest extends FormRequest
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
            'start_parsing' => 'date|nullable',
            'end_parsing' => 'date|nullable',
            'user_name' => 'string|nullable',
            'select_author' => 'integer|nullable',
            'select_domain' => 'integer|nullable',
            'select_ip' => 'integer|nullable',
            'select_all' => 'boolean|nullable',
        ];
    }
}
