<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket;

class Offer extends AbstractOffer
{
    public function getName(): string
    {
        return $this->name;
    }

    public function getDiscountMultiplier(): float
    {
        return $this->percent_discount;
    }
}
