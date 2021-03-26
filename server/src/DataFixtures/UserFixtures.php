<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\ValueObject\Email;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
        $user = new User();
        $user->setEmail(new Email('lukadolancic@gmail.com'));
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, 'test123')
        );
        $user->addRole('ROLE_ADMIN');

        $user2 = new User();
        $user2->setEmail(new Email('lukadolancic2@gmail.com'));
        $user2->setPassword(
            $this->passwordEncoder->encodePassword($user2, 'test123')
        );

        $manager->persist($user);
        $manager->persist($user2);

        $manager->flush();
    }
}
