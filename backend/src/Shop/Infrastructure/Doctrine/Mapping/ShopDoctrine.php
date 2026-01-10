<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Shop\Infrastructure\Doctrine\Mapping;

use App\Shop\Domain\ValueObject\ShopCategory;
use App\Shop\Domain\ValueObject\ShopId;
use App\User\Domain\ValueObject\UserId;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'shop')]
class ShopDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'shop_id', unique: true)]
    public ShopId $id;

    #[ORM\Column(type: 'user_id')]
    public UserId $userId;

    #[ORM\Column(type: 'shop_category', length: 20)]
    public ShopCategory $category;

    #[ORM\Column(type: 'string', length: 100)]
    public string $name;

    #[ORM\Column(type: 'string', length: 255)]
    public string $city;

    #[ORM\Column(type: 'boolean')]
    public bool $isActive = true;

    #[ORM\Column(type: 'datetime_immutable')]
    public DateTimeImmutable $createdAt;
}
