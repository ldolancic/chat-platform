<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as UserAssert;

class RegisterUserRequest
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     * @UserAssert\UniqueUserEmail();
     */
    public string $email;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public string $password;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public string $firstName;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public string $lastName;
}
