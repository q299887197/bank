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
        $userId = $_POST['userId'];
        $action = $_POST['action'];
        $tradeMoney = $_POST['tradeMoney'];

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
