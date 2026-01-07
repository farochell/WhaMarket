<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  wha-market
 */

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $command): CommandResponse;
}
