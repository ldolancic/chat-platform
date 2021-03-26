<?php

namespace App\Factory;

use App\Entity\User;
use App\ValueObject\Email;
use App\Request\RegisterUserRequest;
use App\Factory\Contract\UserFactoryInterface;
use App\ValueObject\Exception\InvalidEmailException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory implements UserFactoryInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param RegisterUserRequest $request
     * @return User
     * @throws InvalidEmailException
     */
    public function createFromRegisterUserRequest(RegisterUserRequest $request): User
    {
        $user = new User();

        $user->setEmail(new Email($request->email));
        $user->setFirstName($request->firstName);
        $user->setLastName($request->lastName);

        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $request->password)
        );

        return $user;
    }
}
