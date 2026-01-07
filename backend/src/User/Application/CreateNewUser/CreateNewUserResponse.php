<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Application\CreateNewUser;

use App\Shared\Application\SerializableResponse;
use App\Shared\Domain\Bus\Command\CommandResponse;
use App\User\Domain\Entity\User;

class CreateNewUserResponse extends SerializableResponse implements CommandResponse {

    public function __construct(
        public readonly string $userId,
        public readonly string $phoneNumber
    ) {}

    public static function fromDomain(
        User $user
    ): self {
        return new self($user->id->value(), $user->phoneNumber->value());
    }
    public function jsonSerialize(): array
    {
        return [
            'userId' => $this->userId,
            'phoneNumber' => $this->phoneNumber
        ];
    }
}
