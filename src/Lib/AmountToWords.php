<?php
declare(strict_types = 1);

namespace Lib;


class AmountToWords
{
    /** @var array  */
    private static $currency = [
        'singular' => 'złoty',
        'plural' => 'złote',
        'multiple' => 'złotych',
    ];

    /** @var array  */
    private static $unitToWord = [
        0 => 'zero',
        1 => 'jeden',
        2 => 'dwa',
        3 => 'trzy',
        4 => 'cztery',
        5 => 'pięć',
        6 => 'sześć',
        7 => 'siedem',
        8 => 'osiem',
        9 => 'dziewięć',
    ];

    /**
     * @param float $amount
     * @return string
     * @internal param string $currency
     */
    public function convert(float $amount): string
    {
        $units = $amount % 10;

        $currencyBasis = $this->getDeclinedCurrency($units);

        return ucfirst(implode(' ',[self::$unitToWord[$units],self::$currency[$currencyBasis]]));
    }

    /**
     * @param $amount
     * @return string
     */
    private function getDeclinedCurrency($amount): string
    {
        switch (true) {
            case $amount === 1:
                $currencyBasis = 'singular';
                break;
            case in_array($amount, [2, 3, 4]) :
                $currencyBasis = 'plural';
                break;
            default:
                $currencyBasis = 'multiple';

                return $currencyBasis;
        }

        return $currencyBasis;
    }
}