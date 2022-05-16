<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket\Exceptions;

use BadMethodCallException;

class BasketTotalFormattingForIso4217NotImplementedException extends BadMethodCallException
{
    public static function format(int $total, string $code): self
    {
        throw new self("The formatting for ISO-4217 code $code has not been implemented.");
    }
}
