<?php

namespace Test\Lib;


use Lib\AmountToWords;


class AmountToWordsTest extends \PHPUnit_Framework_TestCase
{
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
        $this->assertSame('Zero złotych zero groszy', $this->converter->convert(0.00));
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
     * @test
     * @dataProvider getAmountsWithPens
     * @param $number
     * @param $expectedResult
     */
    public function returnProperAmountWithPens($number, $expectedResult)
    {
        $this->assertSame($expectedResult, $this->converter->convert($number));
    }

    /**
     * @return array
     */
    public function getAmountsWithPens()
    {
        return [
            [12.34, 'Dwanaście złotych trzydzieści cztery grosze'],
            [456.22, 'Czterysta pięćdziesiąt sześć złotych dwadzieścia dwa grosze'],
            [1000000.01, 'Jeden milion złotych jeden grosz']
        ];
    }

    /**
     * @return array
     */
    public function getAmounts()
    {
        return [
            [101, 'Sto jeden złotych zero groszy'],
            [156.20, 'Sto pięćdziesiąt sześć złotych dwadzieścia groszy'],
            [1234, 'Jeden tysiąc dwieście trzydzieści cztery złote zero groszy'],
            [1000000, 'Jeden milion złotych zero groszy'],
            [1001000, 'Jeden milion jeden tysiąc złotych zero groszy'],
            [1001001, 'Jeden milion jeden tysiąc jeden złoty zero groszy'],
            [1001002, 'Jeden milion jeden tysiąc dwa złote zero groszy'],
        ];
    }

    /**
     * @return array
     */
    public function getSeveralThousands()
    {
        return [
            [1000, 'Jeden tysiąc złotych zero groszy'],
            [2000, 'Dwa tysiące złotych zero groszy'],
            [3000, 'Trzy tysiące złotych zero groszy'],
            [4000, 'Cztery tysiące złotych zero groszy'],
            [5000, 'Pięć tysięcy złotych zero groszy'],
            [6000, 'Sześć tysięcy złotych zero groszy'],
            [7000, 'Siedem tysięcy złotych zero groszy'],
            [8000, 'Osiem tysięcy złotych zero groszy'],
            [9000, 'Dziewięć tysięcy złotych zero groszy'],
        ];
    }

    /**
     * @return array
     */
    public function getHundredsWithTensAndUnits()
    {
        return [
            [101, "Sto jeden złotych zero groszy"],
            [111, "Sto jedenaście złotych zero groszy"],
            [222, "Dwieście dwadzieścia dwa złote zero groszy"],
            [223, "Dwieście dwadzieścia trzy złote zero groszy"],
            [225, "Dwieście dwadzieścia pięć złotych zero groszy"],
            [345, "Trzysta czterdzieści pięć złotych zero groszy"],
            [456, "Czterysta pięćdziesiąt sześć złotych zero groszy"],
            [578, "Pięćset siedemdziesiąt osiem złotych zero groszy"],
            [690, "Sześćset dziewięćdziesiąt złotych zero groszy"],
            [776, "Siedemset siedemdziesiąt sześć złotych zero groszy"],
            [843, "Osiemset czterdzieści trzy złote zero groszy"],
            [932, "Dziewięćset trzydzieści dwa złote zero groszy"],
        ];
    }

    public function getHundreds()
    {
        return [
            [100, "Sto złotych zero groszy"],
            [200, "Dwieście złotych zero groszy"],
            [300, "Trzysta złotych zero groszy"],
            [400, "Czterysta złotych zero groszy"],
            [500, "Pięćset złotych zero groszy"],
            [600, "Sześćset złotych zero groszy"],
            [700, "Siedemset złotych zero groszy"],
            [800, "Osiemset złotych zero groszy"],
            [900, "Dziewięćset złotych zero groszy"],
        ];
    }

    /**
     * @return array
     */
    public function getTensWithUnits()
    {
        return [
            [21, 'Dwadzieścia jeden złotych zero groszy'],
            [38, 'Trzydzieści osiem złotych zero groszy'],
            [45, 'Czterdzieści pięć złotych zero groszy'],
            [53, 'Pięćdziesiąt trzy złote zero groszy'],
            [64, 'Sześćdziesiąt cztery złote zero groszy'],
            [72, 'Siedemdziesiąt dwa złote zero groszy'],
            [89, 'Osiemdziesiąt dziewięć złotych zero groszy'],
            [96, 'Dziewięćdziesiąt sześć złotych zero groszy'],
        ];
    }

    /**
     * @return array
     */
    public function getTens()
    {
        return [
            [20, 'Dwadzieścia złotych zero groszy'],
            [30, 'Trzydzieści złotych zero groszy'],
            [40, 'Czterdzieści złotych zero groszy'],
            [50, 'Pięćdziesiąt złotych zero groszy'],
            [60, 'Sześćdziesiąt złotych zero groszy'],
            [70, 'Siedemdziesiąt złotych zero groszy'],
            [80, 'Osiemdziesiąt złotych zero groszy'],
            [90, 'Dziewięćdziesiąt złotych zero groszy'],
        ];
    }

    /**
     * @return array
     */
    public function getTeens()
    {
        return [
            [10.00, 'Dziesięć złotych zero groszy'],
            [11.00, 'Jedenaście złotych zero groszy'],
            [12.00, 'Dwanaście złotych zero groszy'],
            [13.00, 'Trzynaście złotych zero groszy'],
            [14.00, 'Czternaście złotych zero groszy'],
            [15.00, 'Piętnaście złotych zero groszy'],
            [16.00, 'Szesnaście złotych zero groszy'],
            [17.00, 'Siedemnaście złotych zero groszy'],
            [18.00, 'Osiemnaście złotych zero groszy'],
            [19.00, 'Dziewiętnaście złotych zero groszy'],
        ];
    }

    /**
     * @return array
     */
    public function getUnits()
    {
        return [
            [0.00, 'Zero złotych zero groszy'],
            [1.00, 'Jeden złoty zero groszy'],
            [2.00, 'Dwa złote zero groszy'],
            [3.00, 'Trzy złote zero groszy'],
            [4.00, 'Cztery złote zero groszy'],
            [5.00, 'Pięć złotych zero groszy'],
            [6.00, 'Sześć złotych zero groszy'],
            [7.00, 'Siedem złotych zero groszy'],
            [8.00, 'Osiem złotych zero groszy'],
            [9.00, 'Dziewięć złotych zero groszy'],
        ];
    }
}
