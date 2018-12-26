<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ArticleCreateRequest extends FormRequest
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
            'article_title' => 'required',
            'subtitle' => 'required',
            'cate_id' => 'required',
            'article_content' => 'required',
            'publish_date' => 'required',
            'layout' => 'required',
        ];
    }

    /**
     * Return the fields and values to create a new post from
     */
    public function postFillData()
    {
        $published_at = new Carbon(
            $this->publish_date . ' ' . $this->publish_time
        );

        return [
            'article_title' => $this->article_title,
            'subtitle' => $this->subtitle,
            'cate_id' => $this->cate_id,
            'article_keywords' => $this->article_keywords,
            'article_description' => $this->article_description,
            'article_thumb' => $this->article_thumb,
            'article_content' => $this->get('article_content'),
            'article_author' => $this->article_author,
            'article_frequency' => 0,
            'layout' => $this->layout,
            'is_draft' => (bool)$this->is_draft,
            'published_at' => $published_at,
        ];
    }
}
