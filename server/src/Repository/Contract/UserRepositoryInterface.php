<?php

namespace App\Repository\Contract;

use App\Entity\User;
use App\ValueObject\Email;
use Doctrine\Persistence\ObjectRepository;

interface UserRepositoryInterface extends ObjectRepository
{
    public function findByEmail(Email $email): ?User;

    public function save(User $user): void;
}
