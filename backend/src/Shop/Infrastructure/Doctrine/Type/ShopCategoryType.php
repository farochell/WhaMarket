<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);


namespace App\Shop\Infrastructure\Doctrine\Type;

use App\Shared\Infrastructure\Doctrine\Type\StringType;
use App\Shop\Domain\ValueObject\ShopCategory;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Override;
use Webmozart\Assert\Assert;

class ShopCategoryType extends StringType
{
    public const string NAME = 'shop_category';

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ShopCategory
    {
        if (null === $value) {
            return null;
        }

        return ShopCategory::tryFrom((string) $value);
    }

    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        Assert::isInstanceOf($value, ShopCategory::class);
        $shopCategory = $value;

        return $shopCategory->value;
    }

    #[Override]
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    #[Override]
    public function getName(): string
    {
        return self::TYPE;
    }
}
