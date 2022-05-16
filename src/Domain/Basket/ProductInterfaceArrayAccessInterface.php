<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket;

use Alistaircol\Hta\Domain\Basket\Concerns\ProductInterface;

interface ProductInterfaceArrayAccessInterface
{
    public function offsetExists(string $offset): bool;
    public function offsetGet(string $offset): ?ProductInterface;
    public function offsetSet(string $offset, ProductInterface $value): void;
    public function offsetUnset(string $offset): void;
}
