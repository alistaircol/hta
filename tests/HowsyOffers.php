<?php declare(strict_types=1);

namespace Tests;

use Alistaircol\Hta\Domain\Basket\Offer;
use Alistaircol\Hta\Domain\Basket\Concerns\OfferInterface;

trait HowsyOffers
{
    public function getOfferTwelveMonthContractTenPercentDiscount(): OfferInterface
    {
        return new Offer([
            'name' => '10% discount for agreeing to a 12-month contract',
            'percent_discount' => 10.0,
        ]);
    }

    public function getOfferNoDiscount(): OfferInterface
    {
        return new Offer([
            'name' => 'No discount for you...',
            'percent_discount' => 0.0,
        ]);
    }

    public function getOfferMajorityDiscount(): OfferInterface
    {
        return new Offer([
            'name' => 'Very generous discount for you...',
            'percent_discount' => 90.0,
        ]);
    }

    public function getOfferFullDiscount(): OfferInterface
    {
        return new Offer([
            'name' => 'Full discount for you...',
            'percent_discount' => 100.0,
        ]);
    }

    public function getOfferOutOfBoundsMinDiscount(): OfferInterface
    {
        return new Offer([
            'name' => 'Negative 10% discount is invalid',
            'percent_discount' => -10.0,
        ]);
    }

    public function getOfferOutOfBoundsMaxDiscount(): OfferInterface
    {
        return new Offer([
            'name' => '> 100% discount is invalid',
            'percent_discount' => 101.0,
        ]);
    }
}
