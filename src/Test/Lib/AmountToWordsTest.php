<?php

namespace Test\Lib;


use Lib\AmountToWords;


class AmountToWordsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function returnZeroForEmptyAmount()
    {
        $converter = new AmountToWords();
        $currency = 'PLN';
        $this->assertEquals('zero '.$currency, $converter->convert(0.00, $currency));
    }
}
