<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Application\CreateNewUser;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Bus\Command\CommandResponse;
use App\User\Domain\Service\UserCreator;
use App\User\Domain\ValueObject\PhoneNumber;
use App\User\Domain\ValueObject\Role;
use App\User\Domain\ValueObject\Roles;

class CreateNewUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserCreator $userCreator
    ) {}

    public function __invoke(CreateNewUserCommand $command): CommandResponse
    {
        $phoneNumber = PhoneNumber::fromString($command->phoneNumber);
        $roles = new Roles([Role::MERCHANT]);
        $fullName = $command->fullName;
        $user = $this->userCreator->create($phoneNumber, $roles, $fullName);

        return CreateNewUserResponse::fromDomain($user);
    }
}
