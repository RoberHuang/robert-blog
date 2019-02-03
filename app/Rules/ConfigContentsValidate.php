<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class ConfigContentsValidate implements Rule
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
        $repository = app('App\Repositories\Contracts\ConfigRepository');
        $ids = $this->request->input('conf_id');
//dd($this->request->all());
        foreach ($ids as $key => $id) {
            $config = $repository->find($id);
            if ($config['data']['type'] == 'radio')
            {
                $contents = [];
                $values = explode(',', $config['data']['value']);
                foreach ($values as $val) {
                    $vals = explode('|', $val);
                    $contents[] = $vals[0];
                }
                if (!in_array($value[$key]??'', $contents)) return false;
            }
            if (is_null($value[$key])) return false;
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
        return '配置内容不能为空或格式错误.';
    }
}
