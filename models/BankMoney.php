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
    ////   用帳號查詢  先判斷是否為空值 並且執行扣款或存款    SELECT  UPDATE
    ///=================================================================
    function SelectGuests($NameID,$MoneyAction,$Money){ //帳戶  存取動作  交易金額
        if($NameID!=null && $Money!=null){
            $dbh = $this->dbh ;
            $slet = $dbh->prepare("SELECT * FROM `Transaction` WHERE `NameID` = :NameID");
            $slet->bindParam(':NameID', $NameID);
            $slet->execute();
            foreach($slet->fetchAll() as $data);
            
            if($MoneyAction=="MoneyIN"){
                $data['Money'] = $data['Money'] + $Money ;
                $UPth = $dbh->prepare("UPDATE `Transaction` SET `Money` = :Money WHERE `NameID`= :NameID");
                $UPth->bindParam(':Money', $data['Money'] );
                $UPth->bindParam(':NameID', $NameID );
                $UPth->execute();
                $dbh = null;
                $data['OK'] = true;
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
                    $data['OK'] = true;
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
    ////  新增帳戶的 明細內容   INSERT
    ///=================================================================  
    function InsertGuestsRecord($NameID,$MoneyAction,$Money,$OverMoney){ //帳戶 存取動作 交易金額 目前餘額
        if($MoneyAction=="MoneyOUT"){
            $MoneyOUT = $Money;
            $MoneyIN = "";
        }
        if($MoneyAction=="MoneyIN"){
            $MoneyIN = $Money;
            $MoneyOUT = "";
        }
        $date= date("Y/m/d H:i:s");
        // var_dump($date);
        // exit;
        $dbh = $this->dbh ;
        $INth = $dbh->prepare("INSERT INTO `Record` (`NameID`,`Date`,`MoneyOUT`,`MoneyIN`,`Money`)
         									VALUES (? , ?, ?, ?, ? )");
        
        $INth->bindParam(1, $NameID );
        $INth->bindParam(2, $date );
        $INth->bindParam(3, $MoneyOUT );
        $INth->bindParam(4, $MoneyIN );
        $INth->bindParam(5, $OverMoney );
        $dbh = null;
        
        // $data['alert'] = "成功";
        
        return $INth->execute();
        
    }

    
    
}