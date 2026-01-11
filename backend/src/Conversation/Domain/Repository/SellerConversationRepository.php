<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Domain\Repository;

use App\Conversation\Domain\Entity\SellerConversation;
use App\User\Domain\ValueObject\PhoneNumber;

interface SellerConversationRepository
{
    public function findByPhoneNumber(PhoneNumber $phoneNumber): ?SellerConversation;
    public function save(SellerConversation $sellerConversation): void;
}
