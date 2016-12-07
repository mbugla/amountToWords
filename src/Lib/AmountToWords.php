<?php
declare(strict_types = 1);

namespace Lib;


class AmountToWords
{
    const THOUSANDS_SEPARATOR = '-';

    /** @var array */
    private static $numberToWord = [
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
        20 => 'dwadzieścia',
        30 => 'trzydzieści',
        40 => 'czterdzieści',
        50 => 'pięćdziesiąt',
        60 => 'sześćdziesiąt',
        70 => 'siedemdziesiąt',
        80 => 'osiemdziesiąt',
        90 => 'dziewięćdziesiąt',
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

    private static $numberMagnitude = [
        0 => 'Tens',
        1 => 'Hundreds',
        2 => 'Thousand',
        3 => 'Milion',
        4 => 'Miliard',
        5 => 'Bilion',
        6 => 'Biliard',
        7 => 'Trylion',
        8 => 'Tryliard',
        9 => 'Kwadrylion',
        10 => 'Kwadryliard',
        11 => 'Kwintylion',
        12 => 'Kwintyliard',
        13 => 'Sekstylion',
        14 => 'Sekstyliard',
    ];

    /**
     * @param float $amount
     * @return string
     * @internal param string $currency
     */
    public function convert(float $amount): string
    {
        if (empty($amount)) {
            return 'Zero złotych zero groszy';
        }

        $amountAsStrings = explode('.', number_format($amount, 2, '.', ''));

        $decimals = (float)$amountAsStrings[1];
        $number = (float)$amountAsStrings[0];

        $currency = Declinations::getCurrency((int)$number);
        $pens = Declinations::getPens((int)$decimals);

        $integerPart = $this->createCompleteWord(implode(' ', $this->getAmountAsWords($number)), $currency);
        $decimalPart = $this->createCompleteWord(implode(' ', $this->getAmountAsWords($decimals)), $pens);

        return ucfirst($integerPart.' '.$decimalPart);
    }

    /**
     * @param float $numberToConvert
     * @return array
     */
    private function getAmountAsWords(float $numberToConvert): array
    {
        if ($numberToConvert == 0) {
            return ['zero'];
        }

        $numberAsString = number_format($numberToConvert, 0, '.', self::THOUSANDS_SEPARATOR);
        $numberParts = explode(self::THOUSANDS_SEPARATOR, $numberAsString);
        $parts = [];
        $numberPartsCount = count($numberParts);

        if($numberPartsCount > count(self::$numberMagnitude)) {
            throw new \OutOfRangeException('Given number is to big and it is not supported.');
        }

        $magnitude = self::$numberMagnitude[$numberPartsCount];
        foreach ($numberParts as $key => $number) {
            $convertedNumber = $this->convertNumber($number);

            if (!empty($convertedNumber)) {
                $parts = array_merge($parts, $convertedNumber);

                if ($magnitude) {
                    $parts[] = Declinations::getMagnitudeDeclination($magnitude, (int)$number);
                }
            }

            $magnitude = self::$numberMagnitude[count($numberParts) - ($key + 1)];
        }

        return $parts;
    }

    /**
     * @param string $numberToConvert
     * @return array
     */
    private function convertNumber(string $numberToConvert): array
    {
        $parts = [];
        $leftToConvert = $numberToConvert;
        $magnitude = $this->getNumberMagnitude($numberToConvert);

        for ($i = 0; $i < ($magnitude + 1); $i++) {
            if (isset(self::$numberToWord[(int)$leftToConvert])) {
                $parts[] = self::$numberToWord[(int)$leftToConvert];
                break;
            }

            $num = (int)($numberToConvert[$i].str_repeat('0', ($magnitude - $i)));

            if ($num == 0) {
                continue;
            }

            $parts[] = self::$numberToWord[$num];
            $leftToConvert = $numberToConvert - $num;
        }

        return $parts;
    }

    /**
     * @param string $amountAsWord
     * @param string $currency
     * @return string
     */
    private function createCompleteWord(string $amountAsWord, string $currency)
    {
        return trim($amountAsWord).' '.trim($currency);
    }

    /**
     * @param $integerPart
     * @return int
     */
    private function getNumberMagnitude(string $integerPart): int
    {
        return strlen($integerPart) - 1;
    }
}