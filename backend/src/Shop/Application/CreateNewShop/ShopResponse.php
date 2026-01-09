<?php

declare(strict_types=1);

namespace App\Shop\Application\CreateNewShop;

use App\Shared\Application\SerializableResponse;
use App\Shared\Domain\Bus\Command\CommandResponse;
use App\Shop\Domain\Entity\Shop;

class ShopResponse extends SerializableResponse implements CommandResponse
{
    public function __construct(
        public string $id,
        public string $name,
        public string $city,
        public string $userId,
    ) {}

    public static function fromDomain(Shop $shop): self
    {
        return new self(
            $shop->id->value(),
            $shop->name,
            $shop->city,
            $shop->userId->value()
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'userId' => $this->userId,
        ];
    }
}
