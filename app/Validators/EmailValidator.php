<?php
namespace Validators;

use Src\Validator\AbstractValidator;

class EmailValidator extends AbstractValidator
{

    protected string $message = 'Email is not valid';

    public function rule(): bool
    {
        return (bool)filter_var($this->value, FILTER_VALIDATE_EMAIL);
    }
}