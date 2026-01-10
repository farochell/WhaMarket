<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Repository;

use App\Shared\Domain\Exception\EntityPersistenceException;
use App\Shared\Infrastructure\Repository\BaseRepository;
use App\Shop\Domain\Entity\Shop;
use App\Shop\Domain\Repository\ShopRepository;
use App\Shop\Domain\ValueObject\ShopId;
use App\Shop\Infrastructure\Doctrine\Mapping\ShopDoctrine;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Throwable;

class MysqlShopRepository extends BaseRepository implements ShopRepository
{

    public function __construct(
        ManagerRegistry $managerRegistry,
        LoggerInterface $logger
    ) {
       parent::__construct(
           $managerRegistry,
           ShopDoctrine::class,
           'Shop',
           $logger,
       ) ;
    }

    public function save(Shop $shop): void
    {
        try {
            $this->getEntityManager()->persist($shop);
            $this->getEntityManager()->flush();
        } catch (Throwable $e) {
            $exception = EntityPersistenceException::fromPrevious(
                $this->entityName,
                $e
            );
            $this->logAndThrowException(
                $exception,
                $shop,
                [  'action' => 'save',  'data' => $this->serializeEntity($user)]
            );
        }
    }

    public function update(Shop $shop): void
    {
        try {
            $this->getEntityManager()->flush();
        } catch (Throwable $e) {
            $exception = EntityPersistenceException::fromPrevious($this->entityName, $e);
            $this->logAndThrowException(
                $exception,
                $shop,
                [  'action' => 'update',  'data' => $this->serializeEntity($user)]
            );
        }
    }

    public function findById(ShopId $id): ?Shop
    {
        $shop = $this->getEntityManager()->getRepository(Shop::class)->find($id);
        if (null === $shop) {
            $this->logAndThrowNotFoundException($id->value());

            return null;
        }
        return $this->transformEntity($shop);
    }

    private function transformEntity(ShopDoctrine $shop): Shop
    {
        return new Shop(
            $shop->id,
            $shop->userId,
            $shop->category,
            $shop->name,
            $shop->city,
            $shop->isActive,
            $shop->createdAt,
        );
    }
}
