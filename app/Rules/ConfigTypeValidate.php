<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class ConfigTypeValidate implements Rule
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
        if($this->request->type == 'radio') {
            if (empty($value))
                return false;
            return preg_match('/^(([0-9a-zA-Z]+\|[\w\x80-\xff]+,)+[0-9a-zA-Z]+\|[\w\x80-\xff]+)*$/i', $value);
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
        return '类型值格式不正确.';
    }
}
