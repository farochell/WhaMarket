<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Domain\Service;

use App\Authentication\Domain\Service\SecretEncoder;
use App\Authentication\Domain\ValueObject\HashedPassword;
use App\Authentication\Domain\ValueObject\Password;
use App\Shared\Domain\Bus\Event\EventBus;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\PhoneNumberAlreadyExistException;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\PhoneNumber;
use App\User\Domain\ValueObject\Role;
use App\User\Domain\ValueObject\Roles;

class UserCreator
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly SecretEncoder $secretEncoder,
        private readonly EventBus $eventBus,
    ) {}

    public function create(
        PhoneNumber $phoneNumber,
        Role $role,
        string $fullName,
        ?string $email = null
    ): User {
        if ($this->userRepository->findByPhoneNumber($phoneNumber)) {
            throw new PhoneNumberAlreadyExistException($phoneNumber->value());
        }
        $clearPassword = $this->generatePassword();
        $plainPassword = Password::fromString($clearPassword);

        $hashed = HashedPassword::fromString(
            $this->secretEncoder->encode($plainPassword)->value()
        );

        $user = User::create(
            $phoneNumber,
            $hashed,
            $clearPassword,
            Roles::fromArray([$role->value]),
            $fullName,
            $email
        );
        $this->userRepository->save($user);
        $events = $user->pullDomainEvents();
        $this->eventBus->publish(...$events);

        return $user;
    }

    private function generatePassword(): string
    {
        return str_pad((string)mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
    }

}
