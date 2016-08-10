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
        $userId = $_POST['userId'];
        $action = $_POST['action'];
        $tradeMoney = $_POST['tradeMoney'];

        $bank = $this->model("BankMoney");
        // 帳戶  存取動作  交易金額
        $guestsMoney = $bank->SelectGuests($userId, $action, $tradeMoney);  //查詢到帳號的餘額
        // if ($guestsMoney['result'] == true) {
            // 帳戶  存取動作  交易金額  目前餘額
            // $bank->InsertGuestsRecord($userId, $action, $tradeMoney, $guestsMoney['balance']);
        // }

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
        $result['userId'] = $_POST['userId'];

        $record = $this->model("MoneyRecord");
        $result['Record'] = $record->SelectGuestsRecord($result['userId']);
        $result['Money'] = $record->SelectGuestsMoney($result['userId']);

        $this->view("Record", $result);

    }

}