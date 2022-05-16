<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket\DataTransferObjects;

use Alistaircol\Hta\Domain\Basket\Concerns\ProductInterface;
use ArrayIterator;

abstract class ProductInterfaceArrayAccess implements ProductInterfaceArrayAccessInterface
{
    protected ArrayIterator $iterator;

    public function __construct(array $collection = [])
    {
        $this->iterator = new ArrayIterator($collection);
    }

    public function offsetExists(string $offset): bool
    {
        return $this->iterator->offsetExists($offset);
    }

    public function offsetGet(string $offset): ?ProductInterface
    {
        return $this->iterator[$offset] ?? null;
    }

    public function offsetSet(string $offset, ProductInterface $value): void
    {
        $this->iterator[$offset] = $value;
    }

    public function offsetUnset(string $offset): void
    {
        unset($this->iterator[$offset]);
    }
}
