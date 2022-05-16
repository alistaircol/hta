<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket\Exceptions;

use Alistaircol\Hta\Domain\Basket\Concerns\OfferInterface;
use OutOfBoundsException;

class OfferDiscountOutOfBoundsException extends OutOfBoundsException
{
    public static function causer(OfferInterface $offer): self
    {
        $name = $offer->getName();
        $discount = $offer->getDiscountMultiplier();

        throw new self("The offer ($name) discount (percentage to be subtracted) is out of bounds. Given {$discount} - it must be (0-100).");
    }
}
