<?php

namespace App\Repositories\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class CategoryValidator.
 *
 * @package namespace App\Repositories\Validators;
 */
class CategoryValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'pid' => 'required',
            'name' =>'bail|required|unique:categories,name',
            'title' => 'required',
            'order' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
