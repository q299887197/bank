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
                if ($data['Money'] >= $tradeMoney) {
                    $update = $dbh->prepare("UPDATE `Transaction` SET `Money` = Money -:tradeMoney
                        WHERE `NameID`= :NameID");
                } else {
                    throw new Exception("餘額不足夠");
                }

            }

            $update->bindParam(':tradeMoney', $tradeMoney, PDO::PARAM_INT);
            $update->bindParam(':NameID', $userId );
            $update->execute();

            /* 新增本次明細 */
            $this->InsertGuestsRecord($userId, $action, $tradeMoney);

            $data['result'] = true;
            // $data['alert'] = "成功";


            $dbh->commit();

        } catch (Exception $err) {
            $dbh->rollBack();
            $data['msg'] = $err->getMessage();
        }

        $dbh = null;

        return $data;
    }


    ///=================================================================
    ////  新增帳戶的 明細內容   INSERT
    ///=================================================================
    function InsertGuestsRecord($userId, $action, $tradeMoney)  //帳戶 存取動作 交易金額 目前餘額
    {
        $dbh = $this->DBH ;

        $date= date("Y/m/d H:i:s");

        if ($action == "withDraw") {
            $depoSit = 0;
            $withDraw = $tradeMoney;
        }

        if ($action == "depoSit") {
            $depoSit = $tradeMoney;
            $withDraw = 0;
        }

        $select = $dbh->prepare("SELECT * FROM `Transaction`
            WHERE `NameID` = :NameID");
        $select->bindParam(':NameID', $userId);
        $select->execute();
        $data = $select->fetch();

        $insert = $dbh->prepare("INSERT INTO `Record` (`NameID`,`Date`,`MoneyOUT`,`MoneyIN`,`Money`)
            VALUES (? , ?, ?, ?, ? )");
        $insert->bindParam(1, $userId );
        $insert->bindParam(2, $date );
        $insert->bindParam(3, $withDraw );
        $insert->bindParam(4, $depoSit );
        $insert->bindParam(5, $data['Money'] );
        // $dbh = null;

        return $insert->execute();
    }

}






// id    NameID    Money

// 1     ABC001    2000
// 2     ABC002    30000
// 3     ABC003    5000