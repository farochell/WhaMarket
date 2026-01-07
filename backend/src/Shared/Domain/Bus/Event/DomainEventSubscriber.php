<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  wha-market
 */

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Event;

interface DomainEventSubscriber
{
    /**
     * @return array<class-string<DomainEvent>>
     */
    public static function subscribedTo(): array;
}
