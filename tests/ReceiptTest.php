<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;


class ReceiptTest extends TestCase {
    public function setUp() {
        $this->Receipt = new Receipt();
    }

    public function tearDown() {
        unset($this->Receipt);
    }
    public function testTotal() {
        $input = [0,2,5,8];
        $output = $this->Receipt->total($input);// Loome objekti
        $this->assertEquals( //PHPUniti testi meetod
            15, // oodatav tulemus
            $output, //Kutsume objektist meetodi Total ja anname ette massiivi numbritest
            'When summing the total should equal 15' //Vea puhul tagastatav teade
        );
    }

    public function testTax(){
        $inputAmount = 10.00;
        $taxInput = 0.10;
        $output = $this->Receipt->tax($inputAmount, $taxInput);
        $this->assertEquals(
            1.0,
            $output,
            'The tax calculation should equal 1.00'
        );
    }
}