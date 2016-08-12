<?php

require_once("models/MoneyRecord.php");

class RecordTest extends \PHPUnit_Framework_TestCase
{

    //開始設定資料
    protected function setUp()
    {
        $db_con = new PdoConfig();
        $db = $db_con->db;
        $insert = $db->prepare("INSERT INTO `Record` (`userId`, `date`, `withdraw`, `deposit`, `balance`)
            VALUES ('test004', '2016-08-16 00:00:00', '2000', '0', 1000)");

        $insert->execute();
    }

	//測試查詢餘額
    public function testSelectBalance()
    {
    	$userId = "test004";

        $moneyRecord = new MoneyRecord();
        $balance = $moneyRecord->selectBalance($userId);

        $this->assertEquals(1000, $balance);
    }

    //測試查詢明細
    public function testSelectRecord()
    {
    	$userId = "test004";
        $expectedResult = Array( 'balance'  =>  '1000',
                                 'record' => Array( 0 => Array( 'userId'    =>  'test004',
                                                                    0       =>  'test004',
                                                                 'date'     =>  '2016-08-16 00:00:00',
                                                                    1       =>  '2016-08-16 00:00:00',
                                                                 'withdraw' =>  '2000',
                                                                    2       =>  '2000',
                                                                 'deposit'  =>  '0',
                                                                    3       =>  '0',
                                                                 'balance'  =>  '1000',
                                                                    4       =>  '1000')));
        $moneyRecord = new MoneyRecord();
        $selectResult = $moneyRecord->selectRecord($userId);

        $this->assertEquals($expectedResult, $selectResult);
    }

    //結束還原
    protected function tearDown()
    {
        $db_con = new PdoConfig();
        $db = $db_con->db;
        $delete = $db->prepare("DELETE FROM `Record` WHERE `userId` = 'test004'");
        $delete->execute();

        $dbh = null;
    }


}
