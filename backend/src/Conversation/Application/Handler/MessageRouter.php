<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Application\Handler;

use App\Conversation\Application\Handler\State\ConversationStateHandler;
use App\Conversation\Domain\Entity\SellerConversation;

final class MessageRouter
{
    /** @param iterable<ConversationStateHandler> $handlers */
    public function __construct(
        public readonly iterable $handlers
    ) {}

    public function route(
        SellerConversation $conversation,
        string $message
    ): SellerConversation {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($conversation)) {
                return $handler->handle($conversation, $message);
            }
        }

        return $conversation;
    }
}
