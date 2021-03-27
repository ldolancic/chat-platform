<?php

namespace App\Tests\Factory;

use App\Entity\User;
use App\Factory\Contract\UserFactoryInterface;
use App\Request\RegisterUserRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserFactoryTest extends KernelTestCase
{
    private UserFactoryInterface $userFactory;

    public function testCreateFromRegisterUserRequest(): void
    {
        $request = new RegisterUserRequest();
        $request->email = 'test@test.test';
        $request->firstName = 'test_fn';
        $request->lastName = 'test_ln';
        $request->password = 'test_pw';

        $user = $this->userFactory->createFromRegisterUserRequest($request);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($request->email, $user->getEmail()->getValue());
        $this->assertEquals($request->firstName, $user->getFirstName());
        $this->assertEquals($request->lastName, $user->getLastName());
    }

    protected function setUp()
    {
        self::bootKernel();
        $this->userFactory = self::$container->get(UserFactoryInterface::class);
    }

}