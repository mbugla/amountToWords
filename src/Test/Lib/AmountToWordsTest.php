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
        $this->assertSame('Zero złotych', $this->converter->convert(0.00));
    }

    /**
     * @test
     * @dataProvider getUnits
     * @param $units
     * @param $expectedResult
     */
    public function returnProperAmountStringForUnits($units, $expectedResult)
    {
        $this->assertSame($expectedResult, $this->converter->convert($units));
    }

    /**
     * @return array
     */
    public function getUnits()
    {
        return [
            [0.00, 'Zero złotych'],
            [1.00, 'Jeden złoty'],
            [2.00, 'Dwa złote'],
            [3.00, 'Trzy złote'],
            [4.00, 'Cztery złote'],
            [5.00, 'Pięć złotych'],
            [6.00, 'Sześć złotych'],
            [7.00, 'Siedem złotych'],
            [8.00, 'Osiem złotych'],
            [9.00, 'Dziewięć złotych'],
        ];
    }
}
