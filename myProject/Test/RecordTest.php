<?php

require_once("myProject/MoneyRecord.php");

class RecordTest extends \PHPUnit_Framework_TestCase
{
	//測試查詢餘額
    public function testSelectBalance()
    {
    	$userId = "ABC003";
    	$expectedResult = 4900;

        $bankMoney = new MoneyRecord();
        $result = $bankMoney->selectBalance($userId);

        $this->assertEquals($expectedResult, $result);
    }
}
