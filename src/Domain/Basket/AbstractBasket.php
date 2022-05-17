<?php

declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket;

use Alistaircol\Hta\Domain\Basket\Concerns\BasketInterface;
use Alistaircol\Hta\Domain\Basket\Concerns\OfferInterface;
use Alistaircol\Hta\Domain\Basket\Concerns\ProductInterface;
use Alistaircol\Hta\Domain\Basket\DataTransferObjects\ProductInterfaceCollection;
use Alistaircol\Hta\Domain\Basket\Exceptions\OfferDiscountOutOfBoundsException;
use Alistaircol\Hta\Domain\Basket\Exceptions\ProductPriceOutOfBoundsException;

abstract class AbstractBasket implements BasketInterface
{
    protected ProductInterfaceCollection $items;
    protected ?OfferInterface $offer = null;

    /**
     * @inheritDoc
     */
    public function applyOffer(OfferInterface $offer): BasketInterface
    {
        $multiplier = $offer->getDiscountMultiplier();
        if ($multiplier < 0 || $multiplier > 100) {
            throw OfferDiscountOutOfBoundsException::causer($offer);
        }

        $this->offer = $offer;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAppliedOffer(): ?OfferInterface
    {
        return $this->offer;
    }

    public function add(ProductInterface $product): BasketInterface
    {
        if ($product->getPrice() < 0) {
            throw ProductPriceOutOfBoundsException::causer($product);
        }

        return $this;
    }

    public function get(string $id): ?ProductInterface
    {
        return $this->items->offsetGet($id);
    }

    /**
     * @inheritDoc
     */
    public function getTotal(): int
    {
        if ($this->items->count() === 0) {
            return 0;
        }

        $total = 0;
        foreach ($this->items as $product) {
            $total += $product->getDiscountedPrice($this->offer);
        }

        return $total;
    }

    /**
     * @inheritDoc
     */
    public function getTotalFormatted(int $total, ?string $iso4217 = 'GBP'): string
    {
        $formatter = new PriceFormatter($iso4217);
        return $formatter->format($total);
    }
}
