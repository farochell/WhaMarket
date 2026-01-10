<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  wha-market
 */

declare(strict_types=1);

namespace App\Shop\Infrastructure\Doctrine\Type;

use App\Shared\Infrastructure\Doctrine\Type\UuidType;
use App\Shop\Domain\ValueObject\ShopId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class ShopIdType extends UuidType
{
    public const string TYPE = 'shop_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL([
            'length' => 16,
            'fixed' => true,
        ]);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        $bin = hex2bin(str_replace('-', '', $value->toString()));

        if (false === $bin) {
            throw new \InvalidArgumentException(sprintf('Valeur invalide "%s" pour ShopIdType', $value->toString()));
        }

        return $bin;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ShopId
    {
        if (null === $value) {
            return null;
        }

        $hex = bin2hex($value);
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($hex, 4));

        return ShopId::fromString($uuid);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
