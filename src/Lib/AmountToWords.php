<?php
declare(strict_types = 1);

namespace Lib;


class AmountToWords
{
    /**
     * @param float $amount
     * @param string $currency
     * @return string
     */
    public function convert(float $amount, string $currency): string
    {
        return "zero ".$currency;
    }
}