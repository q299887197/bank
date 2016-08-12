<?php
require_once("models/PdoConfig.php");
require_once("myProject/BankMoney.php");

class BankTest extends \PHPUnit_Framework_TestCase
{
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
    	$userId = "ABC003";
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
    	$userId = "ABC003";
    	$action = "deposit";
    	$tradeMoney = 1000;

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $balance = $result['balance'];

        $this->assertEquals(5900, $balance);
    }

    //測試取錢
    public function testWithdraw()
    {
    	$userId = "ABC003";
    	$action = "withdraw";
    	$tradeMoney = 1000;

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $balance = $result['balance'];

        $this->assertEquals(3900, $balance);
    }

    //測試取錢_餘額不足
    public function testHasNoBalance()
    {
    	$userId = "ABC003";
    	$action = "withdraw";
    	$tradeMoney = 5000;

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $error = $result['msg'];

        $this->assertEquals('餘額不足夠', $error);
    }
}
