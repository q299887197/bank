<?php

require_once("myProject/BankMoney.php");

class BankTest extends \PHPUnit_Framework_TestCase
{
	//測試存錢
    public function testBankTradeDeposit()
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
    public function testBankTradeWithdraw()
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
}
