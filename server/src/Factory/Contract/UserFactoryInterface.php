<?php

namespace App\Factory\Contract;

use App\Entity\User;
use App\Request\RegisterUserRequest;

interface UserFactoryInterface
{
    public function createFromRegisterUserRequest(RegisterUserRequest $request): User;
}
