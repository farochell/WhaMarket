<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Authentication\Domain\ValueObject\HashedPassword;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\User\Domain\ValueObject\PhoneNumber;
use App\User\Domain\ValueObject\Roles;
use App\User\Domain\ValueObject\UserId;

class User extends AggregateRoot
{
    public function __construct(
        public readonly UserId $id,
        public readonly PhoneNumber $phoneNumber,
        public readonly HashedPassword $hashedPassword,
        public readonly Roles $roles,
        public readonly string $fullName,
        public readonly bool $isActive,
        public readonly ?string $email = null,
    ) {}

    public static function create(
        PhoneNumber $phoneNumber,
        HashedPassword $hashedPassword,
        Roles $roles,
        string $fullName,
        ?string $email = null
    ): self
    {
        return new self(
            UserId::random(),
            $phoneNumber,
            $hashedPassword,
            $roles,
            $fullName,
            true,
            $email,
        );
    }
}
