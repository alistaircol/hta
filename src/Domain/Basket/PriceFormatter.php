<?php declare(strict_types=1);

namespace Alistaircol\Hta\Domain\Basket;

use Alistaircol\Hta\Domain\Basket\Exceptions\BasketTotalFormattingForIso4217NotImplementedException;
use Alistaircol\Hta\Domain\Basket\Exceptions\BasketTotalFormattingInvalidIso4217CodeException;

class PriceFormatter
{
    public string $iso4217;

    public function __construct(string $iso4217 = 'GBP')
    {
        $code = strtoupper($iso4217);
        $code = trim($code);

        if (strlen($code) !== 3) {
            throw BasketTotalFormattingInvalidIso4217CodeException::code($code);
        }

        $this->iso4217 = $code;
    }

    public function format(int $units): string
    {
        // TODO: install an ISO-4217 helper to format when necessary

        switch ($this->iso4217) {
            case 'GBP':
                return '£' . number_format(($units / 100), 2);
            default:
                throw BasketTotalFormattingForIso4217NotImplementedException::format($units, $this->iso4217);
        }
    }
}
