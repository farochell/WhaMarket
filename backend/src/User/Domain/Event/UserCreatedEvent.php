<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;

class UserCreatedEvent extends DomainEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $password,
        public readonly string $phoneNumber,
        ?string $eventId = null,
        ?string $occurredOn = null,
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            $body['password'],
            $body['phoneNumber'],
        );
    }

    public function toPrimitives(): array {
        return [
            'password' => $this->password,
            'phoneNumber' => $this->phoneNumber,
        ];
    }

    public static function eventName(): string {
        return 'user.created';
    }
}
