<?php

declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class OfferDto extends DataTransferObject
{
    public string $name;
    public float $percent_discount;
}
