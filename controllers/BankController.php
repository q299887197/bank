<?php

class BankController extends Controller 
{

    ///=================================================================
    ////  顯示出入款頁面
    ///=================================================================
    function Transaction() 
    {
        $this->view("Transaction");
    }

    function Transactioning()  //按下確定送出
    {
        $nameId = $_POST['NameID'];
        $moneyAction = $_POST['MoneyAction'];
        $money = $_POST['Money'];
        
        $bank = $this->model("BankMoney");
        // 帳戶  存取動作  交易金額
        $guestsMoney = $bank->SelectGuests($nameId, $moneyAction, $money);  //查詢到帳號的餘額
        if($guestsMoney['OK'] == true){
            // 帳戶  存取動作  交易金額  目前餘額
            $bank->InsertGuestsRecord($nameId, $moneyAction, $money, $guestsMoney['Money']); 
        }

        $this->view("Transaction", $guestsMoney);

    }


    ///=================================================================
    ////  顯示明細頁面
    ///=================================================================
    function Record() 
    {
        $this->view("Record");
    }

    function GuestsRecord()  //按下搜尋結果
    {
        $nameId = $_POST['NameID'];

        $bank = $this->model("MoneyRecord");
        $result['Record'] = $bank->SelectGuestsRecord($nameId);
        $result['Money'] = $bank->SelectGuestsMoney($nameId);

        $this->view("Record", $result);

    }

}