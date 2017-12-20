<?php

namespace Leedch\Validator;

use Leedch\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase {

    public function testDateValidation() {
        //$m = new Validator();
        $goodDate = "2017-12-21";
        $goodDateTime = "2017-12-21 13:37:00";
        $badDateMonth = "2014-13-22 00:00:00";
        $badDateDay = "2001-05-32 00:00:00";
        $badDateYear = "200-05-32 00:00:00";
        
        $resultGoodDate = Validator::validateDate($goodDate, "goodDate failed");
        $resultGoodDateTime = Validator::validateDate($goodDateTime, "goodDateTime failed");
        $resultBadDateMonth = Validator::validateDate($badDateMonth, "badDateMonth failed");
        $resultBadDateDay = Validator::validateDate($badDateDay, "badDateDay failed");
        $resultBadDateYear = Validator::validateDate($badDateDay, "badDateYear failed");
        $resultEmpty = Validator::validateDate('', "empty failed");
        $resultInt = Validator::validateDate(5, "int failed");
        
        $this->assertFalse($resultGoodDate);
        $this->assertFalse($resultBadDateMonth);
        $this->assertFalse($resultBadDateDay);
        $this->assertFalse($resultEmpty);
        $this->assertFalse($resultInt);
        $this->assertFalse($resultBadDateMonth);
        $this->assertFalse($resultBadDateYear);
        $this->assertTrue($resultGoodDateTime);
    }
}
