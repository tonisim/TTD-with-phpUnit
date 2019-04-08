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
        $Receipt = new Receipt(); // Loome objekti
        $this->assertEquals( //PHPUniti testi meetod
            14, // oodatav tulemus
            $Receipt->total([0,2,5,8]), //Kutsume objektist meetodi Total ja anname ette massiivi numbritest
            'When summing the total should equal 15' //Vea puhul tagastatav teade
        );
    }
}