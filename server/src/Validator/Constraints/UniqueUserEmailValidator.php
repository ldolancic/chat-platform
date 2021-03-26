<?php

namespace App\Validator\Constraints;

use App\Repository\Contract\UserRepositoryInterface;
use App\ValueObject\Email;
use App\ValueObject\Exception\InvalidEmailException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueUserEmailValidator extends ConstraintValidator
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueUserEmail) {
            throw new UnexpectedTypeException($constraint, UniqueUserEmail::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        try {
            $email = new Email($value);

            $userWithSameEmail = $this->userRepository->findByEmail($email);
        } catch (InvalidEmailException $exception) {
            return;
        }

        if ($userWithSameEmail && $userWithSameEmail->getEmail()->getValue() == $email->getValue()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ email }}', $value)
                ->addViolation();
        }
    }
}
