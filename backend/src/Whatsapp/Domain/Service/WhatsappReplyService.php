<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Whatsapp\Domain\Service;

use App\Conversation\Domain\Entity\SellerConversation;
use App\User\Domain\ValueObject\PhoneNumber;

interface WhatsappReplyService
{
    public function reply(
        SellerConversation $conversation
    ): void;

    public function sendText(PhoneNumber $phoneNumber, string $message): void;
}
