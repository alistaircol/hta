<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket;

use Alistaircol\Hta\Domain\Basket\Concerns\OfferInterface;
use Alistaircol\Hta\Domain\Basket\Concerns\ProductInterface;
use Alistaircol\Hta\Domain\Basket\DataTransferObjects\ProductDto;

abstract class AbstractProduct extends ProductDto implements ProductInterface
{
    public function getDiscountedPrice(?OfferInterface $offer = null): int
    {
        if ($offer === null) {
            return $this->price;
        }

        if ($offer->getDiscountMultiplier() == $offer::DISCOUNT_NONE) {
            return $this->price;
        } elseif ($offer->getDiscountMultiplier() == $offer::DISCOUNT_FULL) {
            return 0;
        }

        $multiplier = (100 - $offer->getDiscountMultiplier()) / 100;

        return intval(ceil($this->price * $multiplier));
    }
}
