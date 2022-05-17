<?php

declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket;

use Alistaircol\Hta\Domain\Basket\Concerns\BasketInterface;
use Alistaircol\Hta\Domain\Basket\Concerns\OfferInterface;
use Alistaircol\Hta\Domain\Basket\Concerns\ProductInterface;
use Alistaircol\Hta\Domain\Basket\DataTransferObjects\ProductInterfaceCollection;
use DomainException;
use PDO;

class SqliteBasket extends AbstractBasket
{
    protected PDO $pdo;

    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

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

    public function applyOffer(OfferInterface $offer): BasketInterface
    {
        throw new DomainException('Not implemented');
    }

    public function add(ProductInterface $product): BasketInterface
    {
        parent::add($product);

        throw new DomainException('Not implemented');
    }

    public function remove(ProductInterface $product): BasketInterface
    {
        throw new DomainException('Not implemented');
    }

    public function getItems(): ProductInterfaceCollection
    {
        throw new DomainException('Not implemented');
    }
}
