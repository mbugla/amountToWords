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
    private static $unitAndTeensToWord = [
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
        10 => 'dziesięć',
        11 => 'jedenaście',
        12 => 'dwanaście',
        13 => 'trzynaście',
        14 => 'czternaście',
        15 => 'piętnaście',
        16 => 'szesnaście',
        17 => 'siedemnaście',
        18 => 'osiemnaście',
        19 => 'dziewiętnaście',
    ];


    /**
     * @param float $amount
     * @return string
     * @internal param string $currency
     */
    public function convert(float $amount): string
    {
        $amountAsStrings = explode('.', number_format($amount, 2, '.', ''));

        $decimals = $amountAsStrings[1];
        $integer = (int)$amountAsStrings[0];

        $currencyBasis = $this->getDeclinedCurrency($integer);

        return ucfirst(implode(' ',[self::$unitAndTeensToWord[$integer],self::$currency[$currencyBasis]]));
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