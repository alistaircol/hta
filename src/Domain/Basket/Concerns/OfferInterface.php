<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket\Concerns;

interface OfferInterface
{
    public const DISCOUNT_FULL = 100;
    public const DISCOUNT_NONE = 0;

    public function getName(): string;
    public function getDiscountMultiplier(): float;
}
