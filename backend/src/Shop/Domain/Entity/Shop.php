<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Shop\Domain\Entity;

use App\Shop\Domain\ValueObject\ShopCategory;
use App\Shop\Domain\ValueObject\ShopId;
use App\User\Domain\ValueObject\UserId;
use DateTimeImmutable;

class Shop
{
    public function __construct(
        public readonly ShopId $id,
        public readonly UserId $userId,
        public readonly ShopCategory $category,
        public readonly string $name,
        public readonly string $city,
        public bool $isActive = true,
        public DateTimeImmutable $createdAt = new DateTimeImmutable()
    ) {}

    public static function create(
        UserId $userId,
        ShopCategory $category,
        string $name,
        string $city
    ): self {
        return new self(
            ShopId::random(),
            $userId,
            $category,
            $name,
            $city
        );
    }
}
