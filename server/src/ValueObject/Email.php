<?php

namespace App\ValueObject;

use App\ValueObject\Exception\InvalidEmailException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

class Email
{
    /**
     * @var string
     */
    private string $value;

    /**
     * Email constructor.
     * @param string $email
     * @throws InvalidEmailException
     */
    public function __construct(string $email)
    {
        $this->validate($email);
        $this->value = $email;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }

    /**
     * @param string $email
     * @throws InvalidEmailException
     */
    private function validate(string $email) : void
    {
        $validator = Validation::createValidator();

        /** @var ConstraintViolationList $errors */
        $errors = $validator->validate($email, new EmailConstraint());

        if ($errors->count() > 0) {
            throw new InvalidEmailException();
        }
    }
}
