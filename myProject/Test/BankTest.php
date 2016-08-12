<?php

require_once("myProject/BankMoney.php");

class BankTest extends \PHPUnit_Framework_TestCase
{
	//測試有輸入空值
    public function testBankTrade_Null()
    {
    	$userId = "";
    	$action = "withdraw";
    	$tradeMoney = "";
    	$expectedResult = "請輸入正確資料";

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $result = $result['msg'];

        $this->assertEquals($expectedResult, $result);
    }

	//測試存錢
    public function testBankTrade_Deposit()
    {
    	$userId = "ABC003";
    	$action = "deposit";
    	$tradeMoney = 1000;
    	$expectedResult = 5900;

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $result = $result['balance'];

        $this->assertEquals($expectedResult, $result);
    }

    //測試取錢
    public function testBankTrade_Withdraw()
    {
    	$userId = "ABC003";
    	$action = "withdraw";
    	$tradeMoney = 1000;
    	$expectedResult = 3900;

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $result = $result['balance'];

        $this->assertEquals($expectedResult, $result);
    }

    //測試取錢_餘額不足
    public function testBankTrade_Withdraw_No()
    {
    	$userId = "ABC003";
    	$action = "withdraw";
    	$tradeMoney = 5000;
    	$expectedResult = "餘額不足夠";

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);
        $result = $result['msg'];

        $this->assertEquals($expectedResult, $result);
    }
}
