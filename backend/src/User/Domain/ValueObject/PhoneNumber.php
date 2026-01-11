<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class PhoneNumber extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    protected function validate($value): void
    {
        if (!preg_match('/^\+[1-9]\d{1,14}$/', $value)) {
            throw new \InvalidArgumentException('Invalid phone number');
        }
    }

    public function equals(string $value): bool
    {
        return $value === $this->value;
    }
}
