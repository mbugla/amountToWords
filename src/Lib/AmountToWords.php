<?php
declare(strict_types = 1);

namespace Lib;


class AmountToWords
{
    /** @var array */
    private static $currency = [
        'singular' => 'złoty',
        'plural' => 'złote',
        'multiple' => 'złotych',
    ];

    /** @var array */
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

    private static $tensToWord = [
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
        20 => 'dwadzieścia',
        30 => 'trzydzieści',
        40 => 'czterdzieści',
        50 => 'pięćdziesiąt',
        60 => 'sześćdziesiąt',
        70 => 'siedemdziesiąt',
        80 => 'osiemdziesiąt',
        90 => 'dziewięćdziesiąt',
    ];

    private static $hundredsToWord = [
        100 => 'sto',
        200 => 'dwieście',
        300 => 'trzysta',
        400 => 'czterysta',
        500 => 'pięćset',
        600 => 'sześćset',
        700 => 'siedemset',
        800 => 'osiemset',
        900 => 'dziewięćset',
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
        $numberToConvert = $amountAsStrings[0];
        $integerMagnitude = $this->getNumberMagnitude($numberToConvert);

        $parts = [];
        $leftToConvert = $numberToConvert;
        for ($i = 0; $i < ($integerMagnitude + 1); $i++) {

            if ($this->isTeenNumber($leftToConvert)) {
                $parts[] = self::$tensToWord[$leftToConvert];
                $num = $leftToConvert;
                break;
            }

            if ($this->isRoundTenWithoutUnits($leftToConvert)) {
                $parts[] = self::$tensToWord[$leftToConvert];
                $num = $leftToConvert;

                break;
            }

            $num = $numberToConvert[$i].str_repeat('0', ($integerMagnitude - $i));

            if ((int)$num == 0) {
                continue;
            }
            switch ($this->getNumberMagnitude((int)$num)) {
                case 0:
                    $dict = self::$unitToWord;
                    break;
                case 1:
                    $dict = self::$tensToWord;
                    break;
                case 2:
                    $dict = self::$hundredsToWord;
                    break;
            }

            $parts[] = $dict[$num];
            $leftToConvert = $numberToConvert - $num;
        }

        $number = implode(' ', $parts);

        $currencyBasis = $this->getDeclinedCurrency((int)$numberToConvert);

        return $this->createCompleteWord($number, self::$currency[$currencyBasis]);
    }

    /**
     * @param $amountInWord
     * @param $currency
     * @return string
     */
    private function createCompleteWord($amountInWord, $currency)
    {
        return ucfirst($amountInWord.' '.$currency);
    }

    /**
     * @param $amount
     * @return string
     */
    private function getDeclinedCurrency($amount): string
    {
        switch (true) {

            case $amount > 1 && $amount > 20 && in_array(substr((string)$amount, -1), [2, 3, 4]):
                $currencyBasis = 'plural';
                break;
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

    /**
     * @param $integerPart
     * @return int
     */
    private function getNumberMagnitude($integerPart): int
    {
        return strlen((string)$integerPart) - 1;
    }

    /**
     * @param $number
     * @return bool
     */
    private function isTeenNumber($number): bool
    {
        return $number > 10 && $number < 20;
    }

    /**
     * @param $number
     * @return bool
     */
    private function isRoundTenWithoutUnits($number): bool
    {
        return $number % 10 == 0 && $number < 100;
    }
}