<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket\Exceptions;

use Alistaircol\Hta\Domain\Basket\Concerns\OfferInterface;
use Alistaircol\Hta\Domain\Basket\Concerns\ProductInterface;
use Alistaircol\Hta\Domain\Basket\PriceFormatter;
use OutOfBoundsException;

class ProductPriceOutOfBoundsException extends OutOfBoundsException
{
    public static function causer(ProductInterface $product): self
    {
        $id = $product->getId();
        $name = $product->getName();
        $price = (new PriceFormatter())->format($product->getPrice());

        throw new self("The product ($id: $name) price is out of bounds. Given {$price} - it must be > 0.");
    }
}
