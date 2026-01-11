<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Application\HandleIncomingMessage;

use App\Shared\Domain\Bus\Command\Command;

class HandleIncomingMessageCommand implements Command
{
    public function __construct(
        public string $phoneNumber,
        public string $message,
        public string $channel,
    ) {}
}
