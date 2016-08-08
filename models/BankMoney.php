<?php
require_once("models/PDOconfig.php");

class BankMoney {
    var $dbh;
    
    function __construct(){  //將 NEW PDO物件放置建構子 並將內容丟給外面的 $dbh讓大家都可以用 
        $db_con = new DB_con();
        $db = $db_con->db;
        $this-> dbh = $db;
    }
    
    ///=================================================================
    ////  判斷是否為空值  用帳號查詢   SELECT
    ///=================================================================
    function SelectGuests($NameID,$MoneyAction,$Money){ //帳戶  存取動作  交易金額
        if($NameID!=null && $Money!=null){
            $dbh = $this->dbh ;
            $slet = $dbh->prepare("SELECT * FROM `Transaction` WHERE `NameID` = :NameID");
            $slet->bindParam(':NameID', $NameID);
            $slet->execute();
            foreach($slet->fetchAll() as $data);
            $data['DateTime']= date("Y/m/d H:i:s");
            
            if($MoneyAction=="MoneyIN"){
                $data['Money'] = $data['Money'] + $Money ;
                $UPth = $dbh->prepare("UPDATE `Transaction` SET `Money` = :Money WHERE `NameID`= :NameID");
                $UPth->bindParam(':Money', $data['Money'] );
                $UPth->bindParam(':NameID', $NameID );
                $UPth->execute();
                $dbh = null;
                $data['alert'] = "成功";
                
                return $data;
            }
            elseif($MoneyAction=="MoneyOUT"){
                if($data['Money'] >= $Money){
                    $data['Money'] = $data['Money'] - $Money ;
                    $UPth = $dbh->prepare("UPDATE `Transaction` SET `Money` = :Money WHERE `NameID`= :NameID");
                    $UPth->bindParam(':Money', $data['Money'] );
                    $UPth->bindParam(':NameID', $NameID );
                    $UPth->execute();
                    $dbh = null;
                    $data['alert'] = "成功";
                    
                    return $data;
                }
                else{
                    $data['alert'] = "餘額不足夠";
                    return $data;
                }
            }
        }
        else{
            $data['alert'] = "請輸入正確資料";
            return $data;
        }
    }
    
    
    ///=================================================================
    ////  更新帳戶的 目前餘額 
    ///=================================================================  
    function UpdateGuests(){
        
        
    }

    
    
}