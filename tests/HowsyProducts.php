<?php declare(strict_types=1);

namespace Tests;

use Alistaircol\Hta\Domain\Basket\Concerns\ProductInterface;
use Alistaircol\Hta\Domain\Basket\Product;

trait HowsyProducts
{
    public function getProductPhotography(): ProductInterface
    {
        return new Product([
            'id' => 'P001',
            'name' => 'Photography',
            'price' => 20000
        ]);
    }

    public function getProductFloorplan(): ProductInterface
    {
        return new Product([
            'id' => 'P002',
            'name' => 'Floorplan',
            'price' => 10000
        ]);
    }

    public function getProductGasCertificate(): ProductInterface
    {
        return new Product([
            'id' => 'P003',
            'name' => 'Gas Certificate',
            'price' => 8350
        ]);
    }

    public function getProductEicrCertificate(): ProductInterface
    {
        return new Product([
            'id' => 'P004',
            'name' => 'EICR Certificate',
            'price' => 5100
        ]);
    }

    public function getProductFreeMoney(): ProductInterface
    {
        return new Product([
            'id' => 'T001',
            'name' => 'We will not give away £10 for free',
            'price' => -1000
        ]);
    }

    public function getProductJustAPenny(): ProductInterface
    {
        return new Product([
            'id' => 'T002',
            'name' => 'Just a penny!',
            'price' => 1
        ]);
    }
}
