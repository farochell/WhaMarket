<?php

declare(strict_types=1);

namespace App\Shop\Application\CreateNewShop;

use App\Shared\Domain\Bus\Command\Command;

class CreateNewShopCommand implements Command
{
    public function __construct(
        public string $phoneNumber,
        public string $category,
        public string $name,
        public string $city,
    ) {}
}
