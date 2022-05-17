<?php declare(strict_types=1);

namespace Tests;

use Alistaircol\Hta\Application;
use Alistaircol\Hta\Domain\Basket\Basket;
use Alistaircol\Hta\Domain\Basket\Concerns\BasketInterface;
use Alistaircol\Hta\Domain\Basket\SqliteBasket;
use DomainException;

final class SqliteBasketTest extends AbstractBasketTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $app = new Application();
        $container = $app->container();

        /** @var BasketInterface $implementation */
        $implementation = $container->get(SqliteBasket::class);

        $this->basket = $implementation->create();
    }

    public function test_creating_basket_with_discount_is_not_implemented(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Not implemented');

        $app = new Application();
        $container = $app->container();

        /** @var BasketInterface $implementation */
        $implementation = $container->get(SqliteBasket::class);

        $this->basket = $implementation->create($this->getOfferFullDiscount());

        $this->assertNull($this->basket->getAppliedOffer());
    }

    public function test_adding_discount_is_not_implemented(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Not implemented');

        $this->assertEquals(SqliteBasket::class, get_class($this->basket));

        $this->basket->applyOffer($this->getOfferFullDiscount());

        $this->assertNull($this->basket->getAppliedOffer());
    }

    public function test_adding_item_is_not_implemented(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Not implemented');

        $this->basket->add($this->getProductPhotography());
    }

    public function test_removing_item_is_not_implemented()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Not implemented');

        $this->basket->remove($this->getProductPhotography());
    }

    public function test_get_item_is_not_implemented()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Not implemented');

        $this->assertCount(0, $this->basket->getItems());
    }
}
