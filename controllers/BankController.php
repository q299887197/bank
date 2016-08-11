<?php

class BankController extends Controller
{
    /* 顯示出入款頁面 */
    public function transaction()
    {
        $this->view("Transaction");
    }

    /* 出入款頁 按下按下確定送出 */
    public function inTrade()
    {
        $userId = $_POST['userId'];
        $action = $_POST['action'];
        $tradeMoney = $_POST['tradeMoney'];

        $bank = $this->model("BankMoney");
        $data = $bank->bankTrade($userId, $action, $tradeMoney);

        $this->view("Transaction", $data);
    }

    /* 顯示明細頁面 */
    public function record()
    {
        $this->view("Record");
    }

    /* 明細頁 按下搜尋結果 */
    public function showRecord()
    {
        $userId = $_POST['userId'];

        $record = $this->model("MoneyRecord");
        $result = $record->selectRecord($userId);

        $this->view("Record", $result);
    }
}
