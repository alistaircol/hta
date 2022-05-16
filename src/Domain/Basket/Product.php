<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket;

class Product extends AbstractProduct
{
    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
