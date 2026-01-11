<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Infrastructure\Doctrine\Type;

use App\Conversation\Domain\ValueObject\Channel;
use App\Shared\Infrastructure\Doctrine\Type\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Override;
use Webmozart\Assert\Assert;

class ChannelType extends StringType
{
    public const string NAME = 'channel';

    #[Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Channel
    {
        if (null === $value) {
            return null;
        }

        return Channel::tryFrom((string) $value);
    }

    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        Assert::isInstanceOf($value, Channel::class);
        $channel = $value;

        return $channel->value;
    }

    #[Override]
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
