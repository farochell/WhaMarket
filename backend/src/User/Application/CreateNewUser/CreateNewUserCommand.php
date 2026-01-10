<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Application\CreateNewUser;

use App\Shared\Domain\Bus\Command\Command;

class CreateNewUserCommand implements Command
{
    public function __construct(
        public readonly string $fullName,
        public readonly string $phoneNumber,
    ) {}
}
