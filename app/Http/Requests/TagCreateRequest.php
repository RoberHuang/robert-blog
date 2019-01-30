<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagCreateRequest extends FormRequest
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
            'name' => 'bail|required|unique:tags,name',
            'title' => 'required',
        ];
    }

    public function fillData()
    {
        return [
            'name' => $this->name,
            'title' => $this->title,
            'page_image' => $this->page_image ?? '',
            'description' => $this->description ?? '',
            'reverse_direction' => (bool) $this->reverse_direction
        ];
    }
}
