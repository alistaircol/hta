<?php

declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket\Exceptions;

use DomainException;

class BasketTotalFormattingInvalidIso4217CodeException extends DomainException
{
    public static function code(string $code): self
    {
        throw new self("The given code is not a valid ISO-4217 code. Code given: $code");
    }
}
