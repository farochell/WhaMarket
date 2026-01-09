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
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\PhoneNumber;
use App\User\Domain\ValueObject\UserId;

class ShopCreator
{
    public function __construct(
        private ShopRepository $shopRepository,
        private UserRepository $userRepository,
    )
    {
    }

    public function create(
        PhoneNumber $phoneNumber,
        ShopCategory $category,
        string $name,
        string $city
    ): ?Shop {
        try {
            $user = $this->userRepository->findByPhoneNumber($phoneNumber);

            if (!$user) {
                throw new UserNotFoundException($phoneNumber->value());
            }

            $shop = Shop::create($user->id, $category, $name, $city);
            $this->shopRepository->save($shop);

            return $shop;
        } catch (UserNotFoundException $exception) {
            return null;
        }
    }
}
