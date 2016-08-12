<?php

require_once("models/BankMoney.php");

class ToolTest extends \PHPUnit_Framework_TestCase {

    public function testRepeatString() {
        $paramCount = 5;
        $paramWhat = "*";
        $expectedResult = "*****";

        $tool = new Tool();
        $result = $tool->repeatString($paramCount, $paramWhat);

        $this->assertEquals($expectedResult, $result);
    }

}

?>