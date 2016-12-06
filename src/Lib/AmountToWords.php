<?php
declare(strict_types = 1);

namespace Lib;


class AmountToWords
{
    const SINGULAR = 'singular';
    const PLURAL = 'plural';
    const MULTIPLE = 'multiple';
    const THOUSANDS_SEPARATOR = '-';

    /** @var array */
    private static $currency = [
        self::SINGULAR => 'złoty',
        self::PLURAL => 'złote',
        self::MULTIPLE => 'złotych',
    ];

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
    ];

    private static $magnitudesDeclinations = [
        'Hundreds' => [
            self::SINGULAR => '',
            self::PLURAL => '',
            self::MULTIPLE => '',
        ],
        'Thousand' => [
            self::SINGULAR => 'tysiąc',
            self::PLURAL => 'tysiące',
            self::MULTIPLE => 'tysięcy',
        ],
        'Milion' => [
            self::SINGULAR => 'milion',
            self::PLURAL => 'miliony',
            self::MULTIPLE => 'milionów',
        ],
        'Miliard' => [
            self::SINGULAR => 'miliard',
            self::PLURAL => 'miliardy',
            self::MULTIPLE => 'miliardów',
        ],
        'Bilion' => [
            self::SINGULAR => 'bilion',
            self::PLURAL => 'biliony',
            self::MULTIPLE => 'bilionów',
        ],
        'Biliard' => [
            self::SINGULAR => 'biliard',
            self::PLURAL => 'biliardy',
            self::MULTIPLE => 'biliardów',
        ],
    ];

    /**
     * @param float $amount
     * @return string
     * @internal param string $currency
     */
    public function convert(float $amount): string
    {
        if (empty($amount)) {
            return 'Zero złotych';
        }

        $amountAsStrings = explode('.', number_format($amount, 2, '.', ''));

        $decimals = $amountAsStrings[1];
        $numberToConvert = $amountAsStrings[0];

        $currency = self::$currency[$this->getCurrencyDeclinationCase((int)$numberToConvert)];

        return $this->createCompleteWord(
            implode(' ', $this->getAmountAsWords($numberToConvert)),
            $currency
        );
    }

    /**
     * @param $numberToConvert
     * @return array
     */
    private function getAmountAsWords($numberToConvert): array
    {
        $numberAsString = number_format((float)$numberToConvert, 0, '.', self::THOUSANDS_SEPARATOR);
        $numberParts = explode(self::THOUSANDS_SEPARATOR, $numberAsString);
        $parts = [];

        $magnitude = self::$numberMagnitude[count($numberParts)];

        foreach ($numberParts as $key => $number) {
            $convertedNumber = $this->convertNumber($number);

            if (!empty($convertedNumber)) {
                $parts = array_merge($parts, $convertedNumber);

                $parts[] = self::$magnitudesDeclinations[$magnitude][$this->getDeclinationCase((int)$number)];
            }

            $magnitude = self::$numberMagnitude[count($numberParts) - ($key + 1)];
        }

        return $parts;
    }


    /**
     * @param $amountInWord
     * @param $currency
     * @return string
     */
    private function createCompleteWord($amountInWord, $currency)
    {
        return ucfirst(trim($amountInWord).' '.trim($currency));
    }

    /**
     * @param $number
     * @return bool
     */
    private function isPowerOfThousand($number)
    {
        $log = log10((float)$number);

        return is_numeric($log) && floor($log) == $log && $log > 2;
    }

    /**
     * @param $amount
     * @return string
     */
    private function getCurrencyDeclinationCase(int $amount): string
    {
        $lastDigit = substr((string)$amount, -1);
        $lastTwoDigits = substr((string)$amount, -2);

        switch (true) {
            case $this->isPowerOfThousand($amount):
                $declinationBase = self::MULTIPLE;
                break;
            case
                $amount > 1000 && $lastDigit < 2 && $lastDigit == 1 && $lastTwoDigits < 10:
                $declinationBase = self::SINGULAR;
                break;
            default:
                $declinationBase = $this->getDeclinationCase($amount);
        }

        return $declinationBase;
    }

    /**
     * @param $amount
     * @return string
     */
    private function getDeclinationCase(int $amount): string
    {
        $lastDigit = substr((string)$amount, -1);

        switch (true) {
            case $this->isPowerOfThousand($amount):
                $declinationBase = self::SINGULAR;
                break;
            case
                $amount > 1 && $amount > 20 && in_array($lastDigit, [2, 3, 4]):
                $declinationBase = self::PLURAL;
                break;
            case $amount === 1:
                $declinationBase = self::SINGULAR;
                break;
            case in_array($amount, [2, 3, 4]) :
                $declinationBase = self::PLURAL;
                break;
            default:
                $declinationBase = self::MULTIPLE;
        }

        return $declinationBase;
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
     * @param $numberToConvert
     * @return array
     */
    private function convertNumber($numberToConvert): array
    {
        $parts = [];
        $leftToConvert = $numberToConvert;
        $integerMagnitude = $this->getNumberMagnitude($numberToConvert);

        for ($i = 0; $i < ($integerMagnitude + 1); $i++) {

            if (isset(self::$numberToWord[(int)$leftToConvert])) {
                $parts[] = self::$numberToWord[(int)$leftToConvert];
                break;
            }

            $num = $numberToConvert[$i].str_repeat('0', ($integerMagnitude - $i));

            if ((int)$num == 0) {
                continue;
            }

            $parts[] = self::$numberToWord[$num];
            $leftToConvert = $numberToConvert - $num;
        }

        return $parts;
    }
}