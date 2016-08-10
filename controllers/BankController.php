<?php

class BankController extends Controller
{
    /* 顯示出入款頁面 */
    function Transaction()
    {
        $this->view("Transaction");
    }

    /* 出入款頁 按下按下確定送出 */
    function InTrade()
    {
        $userId = $_POST['userId']; // 帳戶
        $action = $_POST['action']; // 存取動作
        $tradeMoney = $_POST['tradeMoney']; // 交易金額

        $bank = $this->model("BankMoney");
        $data = $bank->BankTrade($userId, $action, $tradeMoney);

        $this->view("Transaction", $data);

    }

    /* 顯示明細頁面 */
    function Record()
    {
        $this->view("Record");
    }

    /* 明細頁 按下搜尋結果 */
    function ShowRecord()
    {
        $userId = $_POST['userId'];

        $record = $this->model("MoneyRecord");
        $result = $record->SelectRecord($userId);

        $this->view("Record", $result);

    }

}