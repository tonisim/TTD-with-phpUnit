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

    /**
     * @dataProvider provideTotal
     */
    public function testTotal($items, $expected) {
        $coupon = null;
        $output = $this->Receipt->total($items, $coupon);  // Loome objekti
        $this->assertEquals( //phpUniti testi meetod
            $expected, // oodatav tulemus
            $output, //Kutsume objektist meetodi Total ja anname ette massiivi numbritest
            "When summing the total should equal {$expected}" //Vea puhul tagastatav teade
        );
    }
    // testib total meetodit
    public function provideTotal() {
        return [
            // Lisatud võti, mille järgi saab testi filtreerida
            'ints total 16' => [[1,2,5,8], 16],
            [[-1,2,5,8], 14],
            [[1,2,8], 11],
        ];
    }
    //Testib Receipt Total meetodit koos kupongiga
    public function testTotalAndCoupon() {
        $input = [0,2,5,8];
        $coupon = 0.20;
        $output = $this->Receipt->total($input, $coupon);
        $this->assertEquals(
            12,
            $output,
            'When summing the total should equal 12'
        );
    }

    //Testib total meetodi exceptionit
    public function testTotalException(){
        $input = [0,2,5,8];
        $coupon = 1.20;
        $this->expectException('BadMethodCallException');
        $this->Receipt->total($input, $coupon);
    }

    //testib total maksu meetodit
    public function testPostTaxTotal() {
        $items = [1,2,5,8];
        $tax = 0.20;
        $coupon = null;
        // Luuakse uus  Mock Receipt objekt
        $Receipt = $this->getMockBuilder('TDD\Receipt')
            ->setMethods(['tax', 'total'])
            ->getMock();

        // Meetod, mida kutsutakse välja üks kord ning on lisatud oodatud argumendid
        $Receipt->expects($this->once())
            ->method('total')
            ->with($items, $coupon)
            ->will($this->returnValue(10.00));
        $Receipt->expects($this->once())
            ->method('tax')
            ->with(10.00, $tax)
            ->will($this->returnValue(1.00));

        /*
        Kutsutakse välja Receipt objektist postTaxTotal meetod, kus muutujate summa on 16 ja tax on 0.2, aga
        kontrollitrakse seda, et väärtus oleks 11 ja test oleks läbitud, sest varasemalt oli
        määratud muutujate summaks 11 ja tax oli 0.1
        */
        $result = $Receipt->postTaxTotal([1,2,5,8], 0.20, null);
        $this->assertEquals(11.00, $result);
    }
    //testib maksu meetodit
    public function testTax() {
        $inputAmount = 10.00;
        $taxInput = 0.10;
        $output = $this->Receipt->tax($inputAmount, $taxInput);
        $this->assertEquals(
            1.00,
            $output,
            'The tax calculation should equal 1.00'
        );
    }
}