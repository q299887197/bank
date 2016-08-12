<?php

require_once("myProject/BankMoney.php");

class BankTest extends \PHPUnit_Framework_TestCase
{
	//測試存錢
    public function testDeposit()
    {
    	$userId = "ABC003";
    	$action = "deposit";
    	$tradeMoney = 1000;
    	$expectedResult = 5900;

        $bankMoney = new BankMoney();
        $result = $bankMoney->bankTrade($userId, $action, $tradeMoney);

        $this->assertEquals($expectedResult, $result);
    }
}
