<?php

require_once("models/MoneyRecord.php");

class RecordTest extends \PHPUnit_Framework_TestCase
{
	//測試查詢餘額
    public function testSelectBalance()
    {
    	$userId = "test004";

        $moneyRecord = new MoneyRecord();
        $balance = $moneyRecord->selectBalance($userId);

        $this->assertEquals(1000, $balance);
    }

    //測試查詢明細
    // public function testSelectRecord()
    // {
    // 	$userId = "ABC003";
    // 	$expectedResult = "ABC003";


    //     $moneyRecord = new MoneyRecord();
    //     $selectResult = $moneyRecord->selectRecord($userId);
    //     // var_dump($selectResult);
    //     $result = $selectResult['record']['userId'];


    //         $this->assertEquals($expectedResult, $result);
    // }


}
