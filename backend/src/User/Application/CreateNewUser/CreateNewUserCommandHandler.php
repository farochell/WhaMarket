<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Application\CreateNewUser;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\User\Domain\Service\UserCreator;

class CreateNewUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserCreator $userCreator
    ) {}

    public function __invoke(CreateNewUserCommand $command): void
    {

    }
}
