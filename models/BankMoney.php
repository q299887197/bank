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
        $this-> DBH = $db;
    }

    /* 查詢帳號  執行存取款動作    SELECT  UPDATE */
    function SelectGuests($userId, $action, $tradeMoney)
    {
        /*
            $userId     =  帳戶
            $action     =  存取動作
            $tradeMoney =  交易金額
        */

        $dbh = $this->DBH ;

        try{
            $dbh->beginTransaction();

            if ($userId == null || $tradeMoney == null) {
                throw new Exception("請輸入正確資料");
            }

            $select = $dbh->prepare("SELECT * FROM `Transaction`
                WHERE `NameID` = :NameID FOR UPDATE");
            $select->bindParam(':NameID', $userId);
            $select->execute();
            $data = $select->fetch();

            /* 存款 */
            if ($action == "depoSit") {
                $update = $dbh->prepare("UPDATE `Transaction` SET `Money` = Money +:tradeMoney
                    WHERE `NameID`= :NameID");
            }

            /* 取款 */
            if ($action == "withDraw") {
                if ($data['Money'] < $tradeMoney) {
                    throw new Exception("餘額不足夠");
                }

                $update = $dbh->prepare("UPDATE `Transaction` SET `Money` = Money -:tradeMoney
                    WHERE `NameID`= :NameID");
            }

            $update->bindParam(':tradeMoney', $tradeMoney, PDO::PARAM_INT);
            $update->bindParam(':NameID', $userId );
            $update->execute();

            /* 新增本次明細 */
            $this->InsertGuestsRecord($userId, $action, $tradeMoney);

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
    function InsertGuestsRecord($userId, $action, $tradeMoney)
    {
         /*
            $userId     =  帳戶
            $action     =  存取動作
            $tradeMoney =  交易金額
        */

        $dbh = $this->DBH ;

        $date= date("Y/m/d H:i:s");

        //存款
        if ($action == "depoSit") {
            $depoSit = $tradeMoney;
            $withDraw = 0;
        }

        //取款
        if ($action == "withDraw") {
            $depoSit = 0;
            $withDraw = $tradeMoney;
        }

        $select = $dbh->prepare("SELECT * FROM `Transaction`
            WHERE `NameID` = :NameID");
        $select->bindParam(':NameID', $userId);
        $select->execute();

        $data = $select->fetch();
        $balance = $data['Money'];

        $insert = $dbh->prepare("INSERT INTO `Record` (`NameID`,`Date`,`MoneyOUT`,`MoneyIN`,`Money`)
            VALUES (? , ?, ?, ?, ? )");
        $insert->bindParam(1, $userId );
        $insert->bindParam(2, $date );
        $insert->bindParam(3, $withDraw );
        $insert->bindParam(4, $depoSit );
        $insert->bindParam(5, $balance );

        return $insert->execute();
    }

}
