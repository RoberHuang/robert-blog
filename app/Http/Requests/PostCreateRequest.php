<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostCreateRequest extends FormRequest
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
            'title' => 'required',
            'subtitle' => 'required',
            'category_id' => 'required|integer|min:1',
            'content' => 'required',
            'publish_date' => 'required',
            'publish_time' => 'required',
        ];
    }

    /**
     * Return the fields and values to create a new post from
     */
    public function fillData()
    {
        $published_at = new Carbon(
            $this->publish_date . ' ' . $this->publish_time
        );

        return [
            'user_id' => Auth::guard('admin')->user()->id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'keyword' => $this->keyword ?? '',
            'description' => $this->description ?? '',
            'thumbnail' => $this->thumbnail ?? config('blog.page_image'),
            'content' => $this->get('content'),
            'visited' => 0,
            'is_draft' => (bool)$this->is_draft,
            'published_at' => $published_at,
        ];
    }
}
