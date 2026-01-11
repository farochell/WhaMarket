<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Application\Handler\State;

use App\Conversation\Domain\Entity\SellerConversation;
use App\Conversation\Domain\ValueObject\ConversationState;
use App\Conversation\Domain\ValueObject\Messages;

class InscriptionStartConservationStateHandler implements  ConversationStateHandler
{
    public function supports(SellerConversation $conversation): bool
    {
        return $conversation->state === ConversationState::INSCRIPTION_START;
    }

    public function handle(
        SellerConversation $conversation,
        string $message
    ): SellerConversation {
        if (strtolower(trim($message)) === Messages::INSCRIPTION->value)
        {
            return $conversation;
        }

        return $conversation->update(
            ConversationState::WAITING_SHOP_NAME
        );
    }
}
