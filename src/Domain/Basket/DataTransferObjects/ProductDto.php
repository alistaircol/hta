<?php

declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class ProductDto extends DataTransferObject
{
    public string $id;
    public string $name;
    public int $price;
    public string $iso4217 = 'GBP';
}
