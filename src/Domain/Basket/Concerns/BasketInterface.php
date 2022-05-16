<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket\Concerns;

use Alistaircol\Hta\Domain\Basket\ProductInterfaceCollection;

interface BasketInterface
{
    /**
     * Create a basket with an optional offer applied immediately.
     *
     * @param OfferInterface|null $offer
     * @return BasketInterface
     */
    public function create(?OfferInterface $offer): BasketInterface;

    /**
     * Add a new product to the basket.
     *
     * @param ProductInterface $product
     * @return BasketInterface
     */
    public function add(ProductInterface $product): BasketInterface;

    /**
     * Remove the given product from the basket.
     *
     * @param ProductInterface $product
     * @return BasketInterface
     */
    public function remove(ProductInterface $product): BasketInterface;

    /**
     * Get all items in the basket.
     *
     * @return ProductInterfaceCollection
     */
    public function getItems(): ProductInterfaceCollection;

    /**
     * Apply an offer/discount to the basket.
     *
     * @param OfferInterface $offer
     * @return BasketInterface
     */
    public function applyOffer(OfferInterface $offer): BasketInterface;

    /**
     * Get the offer applied to the basket.
     *
     * @return ?OfferInterface
     */
    public function getAppliedOffer(): ?OfferInterface;

    /**
     * Calculate the sum of all products price, with the offer applied (if applicable).
     *
     * The amount given is in the currency's minor unit, e.g. for GBP pence, for USD cents, etc.
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Get the formatted price for the basket total, i.e. currency's minor unit.
     *
     * @param int $total
     * @param string|null $iso4217
     * @return string
     */
    public function getTotalFormatted(int $total, ?string $iso4217 = 'GBP'): string;
}
