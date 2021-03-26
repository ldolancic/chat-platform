<?php

namespace App\Doctrine\Types;

use App\ValueObject\Email;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\ValueObject\Exception\InvalidEmailException;

class EmailType extends StringType
{
    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Email|null
     * @throws InvalidEmailException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        if ($value === null) {
            return null;
        }

        return new Email($value);
    }

    public function getName()
    {
        return Types::EMAIL;
    }
}
