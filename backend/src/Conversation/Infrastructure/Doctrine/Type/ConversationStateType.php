<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Infrastructure\Doctrine\Type;

use App\Conversation\Domain\ValueObject\ConversationState;
use App\Shared\Infrastructure\Doctrine\Type\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Override;
use Webmozart\Assert\Assert;

class ConversationStateType extends StringType
{
    public const string NAME = 'conversation_state';

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ConversationState
    {
        if (null === $value) {
            return null;
        }

        return ConversationState::tryFrom((string) $value);
    }

    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        Assert::isInstanceOf($value, ConversationState::class);
        $conversationState = $value;

        return $conversationState->value;
    }

    #[Override]
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    #[Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
