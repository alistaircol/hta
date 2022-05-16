<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket\DataTransferObjects;

use Alistaircol\Hta\Domain\Basket\Concerns\ProductInterface;
use Countable;
use Iterator;

final class ProductInterfaceCollection extends ProductInterfaceArrayAccess implements Iterator, Countable
{
    public function current(): ProductInterface
    {
        return $this->iterator->current();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    public function key(): float|bool|int|string|null
    {
        return $this->iterator->key();
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
    }

    public function count(): int
    {
        return count($this->iterator);
    }
}
