<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Domain\Entity;

use App\Conversation\Domain\ValueObject\Channel;
use App\Conversation\Domain\ValueObject\ConversationState;
use App\Conversation\Domain\ValueObject\SellerConversationId;
use App\User\Domain\ValueObject\PhoneNumber;
use DateTimeImmutable;

class SellerConversation
{
    public function __construct(
        public readonly SellerConversationId $id,
        public readonly PhoneNumber $phoneNumber,
        public readonly Channel $channel,
        public readonly ConversationState $state,
        public readonly array $payload = [],
        public readonly DateTimeImmutable $updatedAt,
    ) {}

    public  static function create(
        PhoneNumber $phoneNumber,
        Channel $channel,
        ConversationState $state,
        array $payload = []
    ) : self
    {
        return new self(
            SellerConversationId::random(),
            $phoneNumber,
            $channel,
            $state,
            $payload,
            new DateTimeImmutable()
        );
    }

    public function update(ConversationState $state, array $payload = []): self
    {
        return new self(
            $this->id,
            $this->phoneNumber,
            $this->channel,
            $state,
            array_merge($this->payload, $payload),
            new \DateTimeImmutable()
        );
    }

    public function equals(self $other): bool
    {
        return
            $this->phoneNumber->equals($other->phoneNumber->value())
            && $this->channel === $other->channel
            && $this->state === $other->state
            && $this->payloadEquals($other->payload);
    }

    private function payloadEquals(array $otherPayload): bool
    {
        return $this->normalizePayload($this->payload)
            === $this->normalizePayload($otherPayload);
    }

    private function normalizePayload(array $payload): array
    {
        ksort($payload);

        foreach ($payload as $key => $value) {
            if (is_array($value)) {
                $payload[$key] = $this->normalizePayload($value);
            }
        }

        return $payload;
    }
}
