<?php

namespace App\Http\Requests;

use App\Rules\ConfigTypeValidate;
use Illuminate\Foundation\Http\FormRequest;

class ConfigUpdateRequest extends FormRequest
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
            'name' =>'bail|required|unique:configs,name,' . $this->id,
            'type' => 'required',
            'value' => new ConfigTypeValidate($this),
            'order' => 'required|integer|between:0,255',
        ];
    }

    public function fillData()
    {
        return [
            'title'      => $this->title ?? '',
            'name'       => $this->name,
            'type'       => $this->type,
            'value'      => $this->value ?? '',
            'order'      => (int) $this->order,
            'content'    => $this->get('content') ?? '',
            'remark'     => $this->remark ?? '',
        ];
    }
}
