<?php

namespace Test\Lib;


use Lib\AmountToWords;


class AmountToWordsTest extends \PHPUnit_Framework_TestCase
{
    const CURRENCY = 'PLN';

    /** @var AmountToWords */
    private $converter;

    public function setUp()
    {
        $this->converter = new AmountToWords();
    }
    /**
     * @test
     */
    public function returnZeroForEmptyAmount()
    {
        $this->assertSame('zero '.self::CURRENCY, $this->converter->convert(0.00, self::CURRENCY));
    }

    /**
     * @test
     * @dataProvider getUnits
     * @param $units
     * @param $expectedResult
     */
    public function returnProperAmountStringForUnits($units, $expectedResult)
    {
        $this->assertSame($expectedResult.' '.self::CURRENCY, $this->converter->convert($units, self::CURRENCY));
    }

    /**
     * @return array
     */
    public function getUnits()
    {
        return [
            [1.00, 'Jeden'],
            [2.00, 'Dwa'],
            [3.00, 'Trzy'],
            [4.00, 'Cztery'],
            [5.00, 'Pięć'],
            [6.00, 'Sześć'],
            [7.00, 'Siedem'],
            [8.00, 'Osiem'],
            [9.00, 'Dziewięć'],
        ];
    }
}
