<?php
require_once("models/PDOconfig.php");

class BankMoney
{
    var $DBH;

    function __construct()    //將 NEW PDO物件放置建構子 並將內容丟給外面的 $DBH讓大家都可以用
    {
        $db_con = new DB_con();
        $db = $db_con->db;
        $this-> DBH = $db;
    }

    ///=================================================================
    ////   用帳號查詢  先判斷是否為空值 並且執行扣款或存款    SELECT  UPDATE
    ///=================================================================
    function SelectGuests($userId, $action, $tradeMoney)  //帳戶  存取動作  交易金額
    {

        $dbh = $this->DBH ;

        try{
            $dbh->beginTransaction();

            if ($userId && $tradeMoney) {

                $select = $dbh->prepare("SELECT * FROM `Transaction`
                    WHERE `NameID` = :NameID FOR UPDATE");
                $select->bindParam(':NameID', $userId);
                $select->execute();
                $data = $select->fetch();

                // sleep(5);
                if ($action == "depoSit") {
                    $data['balance'] = $data['Money'] + $tradeMoney ;

                    $update = $dbh->prepare("UPDATE `Transaction` SET `Money` = :Money
                        WHERE `NameID`= :NameID");
                    $update->bindParam(':Money', $data['balance'], PDO::PARAM_INT);
                    $update->bindParam(':NameID', $userId );
                    $update->execute();

                    $data['OK'] = true;
                    $data['alert'] = "成功";

                } elseif ($action == "withDraw") {
                    if ($data['Money'] >= $tradeMoney) {
                        $data['balance'] = $data['Money'] - $tradeMoney ;

                        $update = $dbh->prepare("UPDATE `Transaction` SET `Money` = :Money
                            WHERE `NameID`= :NameID");
                        $update->bindParam(':Money', $data['balance'], PDO::PARAM_INT);
                        $update->bindParam(':NameID', $userId );
                        $update->execute();

                        $data['OK'] = true;
                        $data['alert'] = "成功";

                    } else {
                        throw new Exception("餘額不足夠");
                    }

                }

            } else {
                throw new Exception("請輸入正確資料");
            }

            $dbh->commit();

        } catch (Exception $err) {
            $dbh->rollBack();
            $data['alert'] = $err->getMessage();

        }

        $dbh = null;

        return $data;
    }


    ///=================================================================
    ////  新增帳戶的 明細內容   INSERT
    ///=================================================================
    function InsertGuestsRecord($userId, $action, $tradeMoney, $balance)  //帳戶 存取動作 交易金額 目前餘額
    {
        if ($action == "withDraw") {
            $depoSit = 0;
            $withDraw = $tradeMoney;
        }

        if ($action == "depoSit") {
            $depoSit = $tradeMoney;
            $withDraw = 0;
        }

        $date= date("Y/m/d H:i:s");

        $dbh = $this->DBH ;
        $insert = $dbh->prepare("INSERT INTO `Record` (`NameID`,`Date`,`MoneyOUT`,`MoneyIN`,`Money`)
            VALUES (? , ?, ?, ?, ? )");
        $insert->bindParam(1, $userId );
        $insert->bindParam(2, $date );
        $insert->bindParam(3, $withDraw );
        $insert->bindParam(4, $depoSit );
        $insert->bindParam(5, $balance );
        $dbh = null;

        return $insert->execute();
    }

}
