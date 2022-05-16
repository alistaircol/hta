<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket;

use Alistaircol\Hta\Domain\Basket\Concerns\BasketInterface;
use Alistaircol\Hta\Domain\Basket\Concerns\OfferInterface;
use Alistaircol\Hta\Domain\Basket\Concerns\ProductInterface;
use Alistaircol\Hta\Domain\Basket\DataTransferObjects\ProductInterfaceCollection;

class InMemoryBasket extends AbstractBasket
{
    /**
     * Create a new empty basket with optional offer.
     *
     * @param OfferInterface|null $offer
     * @return BasketInterface
     */
    public function create(?OfferInterface $offer = null): BasketInterface
    {
        $this->items = new ProductInterfaceCollection();

        if ($offer instanceof OfferInterface) {
            $this->applyOffer($offer);
        }

        return $this;
    }

    /**
     * Add a product to the basket.
     *
     * @param ProductInterface $product
     * @return BasketInterface
     */
    public function add(ProductInterface $product): BasketInterface
    {
        parent::add($product);
        $this->items->offsetSet($product->getId(), $product);

        return $this;
    }

    /**
     * Remove a product from the basket.
     *
     * @param ProductInterface $product
     * @return BasketInterface
     */
    public function remove(ProductInterface $product): BasketInterface
    {
        if ($this->items->offsetExists($product->getId())) {
            $this->items->offsetUnset($product->getId());
        }

        return $this;
    }

    /**
     * Get items in the basket.
     *
     * @return ProductInterfaceCollection
     */
    public function getItems(): ProductInterfaceCollection
    {
        return $this->items;
    }
}
