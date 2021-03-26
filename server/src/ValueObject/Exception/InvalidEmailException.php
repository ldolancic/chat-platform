<?php

namespace App\ValueObject\Exception;

class InvalidEmailException extends \Exception
{
    protected $message = 'Invalid email value provided.';
}
