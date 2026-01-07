<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  defi-fullstack-app
 */

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Type;

use App\User\Domain\ValueObject\PhoneNumber;
use App\Shared\Infrastructure\Doctrine\Type\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class PhoneNumberType extends StringType
{
    public const string TYPE = 'phone_number';

    #[\Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): PhoneNumber
    {
        return PhoneNumber::fromString((string) $value);
    }
}
