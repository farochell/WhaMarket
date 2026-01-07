<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Shop\Domain\Repository;

use App\Shop\Domain\Entity\Shop;
use App\Shop\Domain\ValueObject\ShopId;

interface ShopRepository {
    public function save(Shop $shop): void;

    public function update(Shop $shop): void;

    public function findById(ShopId $id): ?Shop;
}
