<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\ValueObject\Email;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $user = new User(new Email('fakeuser@email.com'), 'Fake', 'User');
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, 'test123')
        );

        $manager->persist($user);
        $manager->flush();
    }
}
