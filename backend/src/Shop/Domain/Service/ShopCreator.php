<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Shop\Domain\Service;

use App\Shop\Domain\Entity\Shop;
use App\Shop\Domain\Repository\ShopRepository;
use App\Shop\Domain\ValueObject\ShopCategory;
use App\User\Domain\ValueObject\UserId;

class ShopCreator
{
    public function __construct(
        private ShopRepository $shopRepository
    )
    {
    }

    public function create(
        UserId $userId,
        ShopCategory $category,
        string $name,
        string $city
    ): Shop {
        $shop = Shop::create($userId, $category, $name, $city);
        $this->shopRepository->save($shop);

        return $shop;
    }
}
