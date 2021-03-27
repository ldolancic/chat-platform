<?php

use App\Entity\User;
use App\Repository\Contract\UserRepositoryInterface;
use App\Validator\Constraints\UniqueUserEmail;
use App\Validator\Constraints\UniqueUserEmailValidator;
use App\ValueObject\Email;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class UniqueUserEmailValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): UniqueUserEmailValidator
    {
        $existingUserEmail = new Email('existing-user@email.com');

        $user = new User($existingUserEmail, 'Existing', 'User');
        $user->setEmail($existingUserEmail);

        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $userRepository
            ->method('findByEmail')
            ->will(
                $this->returnCallback(function (Email $argument) use ($existingUserEmail, $user) {
                    if ($argument->getValue() === $existingUserEmail->getValue()) {
                        return $user;
                    }

                    return null;
                })
            );

        return new UniqueUserEmailValidator($userRepository);
    }

    public function testWithUniqueEmail()
    {
        $this->validator->validate('non-existing-user@email.com', new UniqueUserEmail());

        $this->assertNoViolation();
    }

    public function testWithExistingEmail()
    {
        $this->validator->validate('existing-user@email.com', new UniqueUserEmail());

        $this->assertHasViolations();
    }

    private function assertHasViolations()
    {
        $this->assertGreaterThan(0, $this->context->getViolations()->count());
    }

}