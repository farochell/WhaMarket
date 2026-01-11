<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Infrastructure\Doctrine\Mapping;

use App\Conversation\Domain\ValueObject\Channel;
use App\Conversation\Domain\ValueObject\ConversationState;
use App\Conversation\Domain\ValueObject\SellerConversationId;
use App\User\Domain\ValueObject\PhoneNumber;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'seller_conversation')]
class SellerConversationDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'seller_conversation_id', unique: true)]
    public SellerConversationId $id;

    #[ORM\Column(type: 'phone_number', length: 20)]
    public PhoneNumber $phoneNumber;

    #[ORM\Column(type: 'channel', length: 100)]
    public Channel $channel;

    #[ORM\Column(type: 'channel', length: 100)]
    public ConversationState $state;

    #[ORM\Column(type: 'json')]
    public array $payload = [];

    #[ORM\Column(type: 'datetime_immutable')]
    public DateTimeImmutable $updatedAt;
}
