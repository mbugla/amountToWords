<?php
declare(strict_types = 1);

namespace Lib;


class Declinations
{
    const SINGULAR = 'singular';
    const PLURAL = 'plural';
    const MULTIPLE = 'multiple';

    /** @var array */
    public static $currency = [
        self::SINGULAR => 'złoty',
        self::PLURAL => 'złote',
        self::MULTIPLE => 'złotych',
    ];

    /** @var array */
    public static $pens = [
        self::SINGULAR => 'grosz',
        self::PLURAL => 'grosze',
        self::MULTIPLE => 'groszy',
    ];

    public static $magnitudesDeclinations = [
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
     * @param $amount
     * @return string
     */
    private static function getCurrencyDeclinationCase(int $amount): string
    {
        $lastDigit = substr((string)$amount, -1);
        $lastTwoDigits = substr((string)$amount, -2);

        switch (true) {
            case $amount == 0:
                $declinationBase = Declinations::MULTIPLE;
                break;
            case self::isPowerOfThousand((float)$amount):
                $declinationBase = Declinations::MULTIPLE;
                break;
            case
                $amount > 1000 && $lastDigit < 2 && $lastDigit == 1 && $lastTwoDigits < 10:
                $declinationBase = Declinations::SINGULAR;
                break;
            default:
                $declinationBase = self::getDeclinationCase($amount);
        }

        return $declinationBase;
    }


    /**
     * @param $number
     * @return bool
     */
    private static function isPowerOfThousand(float $number): bool
    {
        $log = log10($number);

        return is_numeric($log) && floor($log) == $log && $log > 2;
    }

    /**
     * @param $amount
     * @return string
     */
    private static function getDeclinationCase(int $amount): string
    {
        $lastDigit = substr((string)$amount, -1);

        switch (true) {
            case self::isPowerOfThousand((float)$amount):
                $declinationBase = Declinations::SINGULAR;
                break;
            case
                $amount > 1 && $amount > 20 && in_array($lastDigit, [2, 3, 4]):
                $declinationBase = Declinations::PLURAL;
                break;
            case $amount === 1:
                $declinationBase = Declinations::SINGULAR;
                break;
            case in_array($amount, [2, 3, 4]) :
                $declinationBase = Declinations::PLURAL;
                break;
            default:
                $declinationBase = Declinations::MULTIPLE;
        }

        return $declinationBase;
    }

    public static function getCurrency(int $number): string
    {
        return self::$currency[self::getCurrencyDeclinationCase($number)];
    }

    public static function getPens(int $number): string
    {
        return self::$pens[self::getCurrencyDeclinationCase($number)];
    }

    public static function getMagnitudeDeclination(string $magnitude, int $amount): string
    {
        if(!isset(self::$magnitudesDeclinations[$magnitude])) {
            return '';
        }

        return self::$magnitudesDeclinations[$magnitude][self::getDeclinationCase($amount)];
    }
}