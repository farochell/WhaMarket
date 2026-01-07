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
        private readonly SecretEncoder $secretEncoder
    ) {}

    public function create(
        PhoneNumber $phoneNumber,
        Password $plainPassword,
        Role $role,
        string $fullName,
        ?string $email = null
    ): User {
        if ($this->userRepository->findByPhoneNumber($phoneNumber)) {
            throw new PhoneNumberAlreadyExistException($phoneNumber->value());
        }

        $hashed = HashedPassword::fromString(
            $this->secretEncoder->encode($plainPassword)->value()
        );

        $user = User::create(
            $phoneNumber,
            $hashed,
            Roles::fromArray([$role->value]),
            $fullName,
            $email
        );

        $this->userRepository->save($user);

        return $user;
    }
}
