<?php
require_once("models/PDOconfig.php");

class BankMoney
{
    var $DBH;

    /* 將 NEW PDO物件放置建構子 並將內容丟給外面的 $dbh讓大家都可以用*/
    function __construct()
    {
        $db_con = new DB_con();
        $db = $db_con->db;
        $this->DBH = $db;
    }

    /* 查詢帳號  執行存取款動作    SELECT  UPDATE */
    function BankTrade($userId, $action, $tradeMoney)
    {
        $dbh = $this->DBH ;

        try{
            $dbh->beginTransaction();

            if ($userId == null || $tradeMoney == null) {
                throw new Exception("請輸入正確資料");
            }

            $select = $dbh->prepare("SELECT * FROM `account`
                WHERE `userId` = :userId FOR UPDATE");
            $select->bindParam(':userId', $userId);
            $select->execute();
            $data = $select->fetch();

            /* 存款 */
            if ($action == "deposit") {
                $update = $dbh->prepare("UPDATE `account` SET `balance` = balance + :tradeMoney
                    WHERE `userId`= :userId");
            }

            /* 取款 */
            if ($action == "withdraw") {
                if ($data['balance'] < $tradeMoney) {
                    throw new Exception("餘額不足夠");
                }

                $update = $dbh->prepare("UPDATE `account` SET `balance` = balance - :tradeMoney
                    WHERE `userId`= :userId");
            }

            $update->bindParam(':tradeMoney', $tradeMoney, PDO::PARAM_INT);
            $update->bindParam(':userId', $userId);
            $update->execute();

            /* 新增本次明細 */
            $this->InsertRecord($userId, $action, $tradeMoney);

            $data['result'] = true;

            $dbh->commit();

        } catch (Exception $err) {
            $dbh->rollBack();
            $data['msg'] = $err->getMessage();
        }

        $dbh = null;

        return $data;
    }

    /* 查詢帳號  新增明細    SELECT  INSERT */
    function InsertRecord($userId, $action, $tradeMoney)
    {
        $dbh = $this->DBH ;

        $date= date("Y/m/d H:i:s");

        //存款
        if ($action == "deposit") {
            $deposit = $tradeMoney;
            $withdraw = 0;
        }

        //取款
        if ($action == "withdraw") {
            $deposit = 0;
            $withdraw = $tradeMoney;
        }

        $select = $dbh->prepare("SELECT * FROM `account`
            WHERE `userId` = :userId");
        $select->bindParam(':userId', $userId);
        $select->execute();

        $data = $select->fetch();
        $balance = $data['balance'];

        $insert = $dbh->prepare("INSERT INTO `Record` (`userId`, `date`, `withdraw`, `deposit`, `balance`)
            VALUES (?, ?, ?, ?, ?)");
        $insert->bindParam(1, $userId);
        $insert->bindParam(2, $date);
        $insert->bindParam(3, $withdraw);
        $insert->bindParam(4, $deposit);
        $insert->bindParam(5, $balance);

        return $insert->execute();
    }
}
