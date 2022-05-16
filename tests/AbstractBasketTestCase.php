<?php declare(strict_types=1);

namespace Tests;

use Alistaircol\Hta\Domain\Basket\Concerns\BasketInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractBasketTestCase extends TestCase
{
    use HowsyProducts;
    use HowsyOffers;

    protected BasketInterface $basket;
}
