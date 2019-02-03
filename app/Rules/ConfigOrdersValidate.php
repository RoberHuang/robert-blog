<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class ConfigOrdersValidate implements Rule
{
    protected $request;

    /**
     * Create a new rule instance.
     *
     * ConfigTypeValidate constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ids = $this->request->input('conf_id');
//dd($this->request->all());
        foreach ($ids as $key => $id) {
            if (preg_match('/^\d+$/i', $value[$key]) === 0) return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '排序值必须是整数.';
    }
}
