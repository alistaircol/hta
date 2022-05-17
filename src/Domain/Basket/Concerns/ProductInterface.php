<?php

declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket\Concerns;

interface ProductInterface
{
    public function getId(): string;
    public function getName(): string;
    public function getPrice(): int;
    public function getDiscountedPrice(?OfferInterface $offer = null): int;
}
