<?php

namespace App\Http\Requests;

use App\Rules\ConfigContentsValidate;
use App\Rules\ConfigOrdersValidate;
use Illuminate\Foundation\Http\FormRequest;

class ConfigSetRequest extends FormRequest
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
            'content' => new ConfigContentsValidate($this),
            'order' => new ConfigOrdersValidate($this),
        ];
    }
}
