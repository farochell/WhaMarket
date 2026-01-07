<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Authentication\Domain\ValueObject\HashedPassword;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\User\Domain\Event\UserCreatedEvent;
use App\User\Domain\ValueObject\PhoneNumber;
use App\User\Domain\ValueObject\Roles;
use App\User\Domain\ValueObject\UserId;
use DateTimeImmutable;

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
        public readonly ?DateTimeImmutable $createdAt = null,
    ) {}

    public static function create(
        PhoneNumber $phoneNumber,
        HashedPassword $hashedPassword,
        string $clearPassword,
        Roles $roles,
        string $fullName,
        ?string $email = null
    ): self
    {
        $user = new self(
            UserId::random(),
            $phoneNumber,
            $hashedPassword,
            $roles,
            $fullName,
            true,
            $email,
            createdAt: new \DateTimeImmutable()
        );

        $user->record(
            new UserCreatedEvent(
                $user->id->value(),
                $clearPassword,
                $user->phoneNumber->value(),
            )
        );

        return $user;
    }
}
