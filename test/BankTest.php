<?php
require_once("models/PdoConfig.php");
require_once("models/BankMoney.php");

class BankTest extends \PHPUnit_Framework_TestCase
{

    //開始設定資料
    protected function setUp()
    {
        $db_con = new PdoConfig();
        $db = $db_con->db;
        $update = $db->prepare("UPDATE `account` SET `balance` = 1000
                    WHERE `userId`= 'test004'");
        $update->execute();
    }

	//測試 帳號輸入空值
    public function testUserIdNull()
    {
    	$userId = "";
    	$action = "withdraw";
    	$tradeMoney = 1000;

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $error = $result['msg'];

        $this->assertEquals('請輸入正確資料', $error);
    }

    //測試 金額輸入空值
    public function testTradeMoneyNull()
    {
    	$userId = "test004";
    	$action = "withdraw";
    	$tradeMoney = "";

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $error = $result['msg'];

        $this->assertEquals('請輸入正確資料', $error);
    }

	//測試存錢
    public function testDeposit()
    {
    	$userId = "test004";
    	$action = "deposit";
    	$tradeMoney = 1000;

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $balance = $result['balance'];

        $this->assertEquals(2000, $balance);
    }

    //測試取錢
    public function testWithdraw()
    {
    	$userId = "test004";
    	$action = "withdraw";
    	$tradeMoney = 1000;

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $balance = $result['balance'];

        $this->assertEquals(0, $balance);
    }

    //測試取錢_餘額不足
    public function testHasNoBalance()
    {
    	$userId = "test004";
    	$action = "withdraw";
    	$tradeMoney = 2000;

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $error = $result['msg'];

        $this->assertEquals('餘額不足夠', $error);
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
