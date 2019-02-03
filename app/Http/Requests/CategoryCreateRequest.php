<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
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
            'name' =>'bail|required|unique:categories,name',
            'order' => 'required',
            'pid' => 'required',
        ];
    }

    public function fillData()
    {
        $pid_level = explode('-', $this->pid);

        return [
            'pid' => $pid_level[0],
            'name' => $this->name,
            'title' => $this->title ?? '',
            'level' => $pid_level[1] + 1,
            'description' => $this->description ?? '',
            'order' => $this->order ?? 0,
        ];
    }
}
