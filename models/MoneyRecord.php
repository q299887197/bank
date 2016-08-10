<?php
require_once("models/PDOconfig.php");

class MoneyRecord
{
    var $DBH;

    /* 將 NEW PDO物件放置建構子 並將內容丟給外面的 $dbh讓大家都可以用*/
    function __construct()
    {
        $db_con = new DB_con();
        $db = $db_con->db;
        $this-> DBH = $db;
    }

    /* 查詢明細    SELECT */
    function SelectGuestsRecord($userId)
    {
        $dbh = $this->DBH;
        $select = $dbh->prepare("SELECT * FROM `Record` WHERE `NameID` = :NameID");
        $select->bindParam(':NameID', $userId);
        $select->execute();

        //查詢餘額
        $data['balance'] = $this->SelectGuestsMoney($userId);

        $data['record'] = $select->fetchAll();

        return $data;
    }

    /* 查詢餘額    SELECT */
    function SelectGuestsMoney($userId)
    {
        $dbh = $this->DBH;
        $select = $dbh->prepare("SELECT * FROM `Transaction` WHERE `NameID` = :NameID");
        $select->bindParam(':NameID', $userId);
        $select->execute();

        $data = $select->fetch();
        $balance = $data['Money'];

        return $balance;
    }

}