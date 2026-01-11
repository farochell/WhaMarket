<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Application\Handler\State;

use App\Conversation\Domain\Entity\SellerConversation;

interface ConversationStateHandler
{
    public function supports(SellerConversation $conversation): bool;

    public function handle(
        SellerConversation $conversation,
        string $message
    ): SellerConversation;
}
