<?php
require_once("models/PDOconfig.php");

class MoneyRecord
{
    public $dbh;

    /* 將 NEW PDO物件放置建構子 並將內容丟給外面的 $dbh讓大家都可以用*/
    public function __construct()
    {
        $db_con = new DB_con();
        $db = $db_con->db;
        $this->dbh = $db;
    }

    /* 查詢明細    SELECT */
    public function SelectRecord($userId)
    {
        $dbh = $this->dbh;
        $select = $dbh->prepare("SELECT * FROM `Record` WHERE `userId` = :userId");
        $select->bindParam(':userId', $userId);
        $select->execute();

        //查詢餘額
        $data['balance'] = $this->SelectBalance($userId);

        $data['record'] = $select->fetchAll();

        return $data;
    }

    /* 查詢餘額    SELECT */
    public function SelectBalance($userId)
    {
        $dbh = $this->dbh;
        $select = $dbh->prepare("SELECT * FROM `account` WHERE `userId` = :userId");
        $select->bindParam(':userId', $userId);
        $select->execute();

        $data = $select->fetch();
        $balance = $data['balance'];

        return $balance;
    }
}
