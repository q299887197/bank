<?php
require_once("models/PDOconfig.php");

class MoneyRecord {
    var $DBH;
    
    function __construct(){  //將 NEW PDO物件放置建構子 並將內容丟給外面的 $dbh讓大家都可以用 
        $db_con = new DB_con();
        $db = $db_con->db;
        $this-> DBH = $db;
    }
    
    ///=================================================================
    ////   用帳號查詢  查詢所有提款存款紀錄    SELECT
    ///=================================================================
    function SelectGuestsRecord($NameID){
        $dbh = $this->DBH;
        $slet = $dbh->prepare("SELECT * FROM `Record` WHERE `NameID` = :NameID");
        $slet->bindParam(':NameID', $NameID);
        $slet->execute();
        // foreach($slet->fetchAll() as $data);
        return $slet->fetchAll();
    }
    
    ///=================================================================
    ////   用帳號查詢  查詢使用者目前剩下的餘額    SELECT
    ///=================================================================
    function SelectGuestsMoney($NameID){
        $dbh = $this->DBH;
        $slet = $dbh->prepare("SELECT * FROM `Transaction` WHERE `NameID` = :NameID");
        $slet->bindParam(':NameID', $NameID);
        $slet->execute();
        foreach($slet->fetchAll() as $data);
        
        return $data['Money'];
    }  
    
}