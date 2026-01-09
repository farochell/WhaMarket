<?php

declare(strict_types=1);

namespace App\Shop\Application\CreateNewShop;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Bus\Command\CommandResponse;
use App\Shared\Domain\Bus\Command\EmptyCommandResponse;
use App\Shop\Domain\Repository\ShopRepository;
use App\Shop\Domain\Service\ShopCreator;
use App\Shop\Domain\ValueObject\ShopCategory;
use App\User\Domain\ValueObject\PhoneNumber;

class CreateNewShopCommandHandler implements CommandHandler
{
    public function __construct(
        public readonly ShopCreator $shopCreator,
    ) {}

    public function __invoke(CreateNewShopCommand $command): CommandResponse
    {
        $shop = $this->shopCreator->create(
            PhoneNumber::fromString($command->phoneNumber),
            ShopCategory::from($command->category),
            $command->name,
            $command->city
        );

        if (!$shop) {
            return new EmptyCommandResponse();
        }
    }
}
