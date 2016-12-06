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
     * @test
     * @dataProvider getTeens
     * @param $number
     * @param $expectedResult
     */
    public function returnProperAmountStringForTeens($number, $expectedResult)
    {
        $this->assertSame($expectedResult, $this->converter->convert($number));
    }

    /**
     * @test
     * @dataProvider getTens
     * @param $number
     * @param $expectedResult
     */
    public function returnProperAmountForTens($number, $expectedResult)
    {
        $this->assertSame($expectedResult, $this->converter->convert($number));
    }

    /**
     * @test
     * @dataProvider getTensWithUnits
     * @param $number
     * @param $expectedResult
     */
    public function returnProperAmountForTensWithUnits($number, $expectedResult)
    {
        $this->assertSame($expectedResult, $this->converter->convert($number));
    }

    /**
     * @test
     * @dataProvider getHundreds
     * @param $number
     * @param $expectedResult
     */
    public function returnProperAmountForHundreds($number, $expectedResult)
    {
        $this->assertSame($expectedResult, $this->converter->convert($number));
    }

    /**
     * @test
     * @dataProvider getHundredsWithTensAndUnits
     * @param $number
     * @param $expectedResult
     */
    public function returnProperAmountForHundredsWithTensAndUnits($number, $expectedResult)
    {
        $this->assertSame($expectedResult, $this->converter->convert($number));
    }

    /**
     * @test
     * @dataProvider getSeveralThousands
     * @param $number
     * @param $expectedResult
     */
    public function returnProperAmountForSeveralThousands($number, $expectedResult)
    {
        $this->assertSame($expectedResult, $this->converter->convert($number));
    }

    /**
     * @test
     * @dataProvider getAmounts
     * @param $number
     * @param $expectedResult
     */
    public function returnProperAmount($number, $expectedResult)
    {
        $this->assertSame($expectedResult, $this->converter->convert($number));
    }

    /**
     * @return array
     */
    public function getAmounts()
    {
        return [
            [101, 'Sto jeden złotych'],
            [1234, 'Jeden tysiąc dwieście trzydzieści cztery złote'],
            [1000000, 'Jeden milion złotych'],
            [1001000, 'Jeden milion jeden tysiąc złotych'],
            [1001001, 'Jeden milion jeden tysiąc jeden złoty'],
            [1001002, 'Jeden milion jeden tysiąc dwa złote'],
        ];
    }

    /**
     * @return array
     */
    public function getSeveralThousands()
    {
        return [
            [1000, 'Jeden tysiąc złotych'],
            [2000, 'Dwa tysiące złotych'],
            [3000, 'Trzy tysiące złotych'],
            [4000, 'Cztery tysiące złotych'],
            [5000, 'Pięć tysięcy złotych'],
            [6000, 'Sześć tysięcy złotych'],
            [7000, 'Siedem tysięcy złotych'],
            [8000, 'Osiem tysięcy złotych'],
            [9000, 'Dziewięć tysięcy złotych'],
        ];
    }

    /**
     * @return array
     */
    public function getHundredsWithTensAndUnits()
    {
        return [
            [101, "Sto jeden złotych"],
            [111, "Sto jedenaście złotych"],
            [222, "Dwieście dwadzieścia dwa złote"],
            [223, "Dwieście dwadzieścia trzy złote"],
            [225, "Dwieście dwadzieścia pięć złotych"],
            [345, "Trzysta czterdzieści pięć złotych"],
            [456, "Czterysta pięćdziesiąt sześć złotych"],
            [578, "Pięćset siedemdziesiąt osiem złotych"],
            [690, "Sześćset dziewięćdziesiąt złotych"],
            [776, "Siedemset siedemdziesiąt sześć złotych"],
            [843, "Osiemset czterdzieści trzy złote"],
            [932, "Dziewięćset trzydzieści dwa złote"],
        ];
    }

    public function getHundreds()
    {
        return [
            [100, "Sto złotych"],
            [200, "Dwieście złotych"],
            [300, "Trzysta złotych"],
            [400, "Czterysta złotych"],
            [500, "Pięćset złotych"],
            [600, "Sześćset złotych"],
            [700, "Siedemset złotych"],
            [800, "Osiemset złotych"],
            [900, "Dziewięćset złotych"],
        ];
    }

    /**
     * @return array
     */
    public function getTensWithUnits()
    {
        return [
            [21, 'Dwadzieścia jeden złotych'],
            [38, 'Trzydzieści osiem złotych'],
            [45, 'Czterdzieści pięć złotych'],
            [53, 'Pięćdziesiąt trzy złote'],
            [64, 'Sześćdziesiąt cztery złote'],
            [72, 'Siedemdziesiąt dwa złote'],
            [89, 'Osiemdziesiąt dziewięć złotych'],
            [96, 'Dziewięćdziesiąt sześć złotych'],
        ];
    }

    /**
     * @return array
     */
    public function getTens()
    {
        return [
            [20, 'Dwadzieścia złotych'],
            [30, 'Trzydzieści złotych'],
            [40, 'Czterdzieści złotych'],
            [50, 'Pięćdziesiąt złotych'],
            [60, 'Sześćdziesiąt złotych'],
            [70, 'Siedemdziesiąt złotych'],
            [80, 'Osiemdziesiąt złotych'],
            [90, 'Dziewięćdziesiąt złotych'],
        ];
    }

    /**
     * @return array
     */
    public function getTeens()
    {
        return [
            [10.00, 'Dziesięć złotych'],
            [11.00, 'Jedenaście złotych'],
            [12.00, 'Dwanaście złotych'],
            [13.00, 'Trzynaście złotych'],
            [14.00, 'Czternaście złotych'],
            [15.00, 'Piętnaście złotych'],
            [16.00, 'Szesnaście złotych'],
            [17.00, 'Siedemnaście złotych'],
            [18.00, 'Osiemnaście złotych'],
            [19.00, 'Dziewiętnaście złotych'],
        ];
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
