<?php
require_once("models/PDOconfig.php");

class MoneyRecord
{
    var $DBH;

    function __construct()    //將 NEW PDO物件放置建構子 並將內容丟給外面的 $dbh讓大家都可以用
    {
        $db_con = new DB_con();
        $db = $db_con->db;
        $this-> DBH = $db;
    }

    ///=================================================================
    ////   用帳號查詢  查詢所有提款存款紀錄    SELECT
    ///=================================================================
    function SelectGuestsRecord($userId)
    {
        $dbh = $this->DBH;
        $select = $dbh->prepare("SELECT * FROM `Record` WHERE `NameID` = :NameID");
        $select->bindParam(':NameID', $userId);
        $select->execute();

        return $select->fetchAll();
    }

    ///=================================================================
    ////   用帳號查詢  查詢使用者目前剩下的餘額    SELECT
    ///=================================================================
    function SelectGuestsMoney($userId)
    {
        $dbh = $this->DBH;
        $select = $dbh->prepare("SELECT * FROM `Transaction` WHERE `NameID` = :NameID");
        $select->bindParam(':NameID', $userId);
        $select->execute();

        $data = $select->fetch();

        return $data['Money'];
    }

}