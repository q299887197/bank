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
    function SelectGuests($nameId, $moneyAction, $money)  //帳戶  存取動作  交易金額
    {
        $dbh = $this->DBH ;
        
        try{
            $dbh->beginTransaction();
            
            if ($nameId!=null && $money!=null) {
                
                $slet = $dbh->prepare("SELECT * FROM `Transaction` 
                    WHERE `NameID` = :NameID FOR UPDATE");
                $slet->bindParam(':NameID', $nameId);
                $slet->execute();
                $data = $slet->fetch();

                sleep(5);
                if ($moneyAction == "MoneyIN") {
                    $data['Money'] = $data['Money'] + $money ;

                    $UPth = $dbh->prepare("UPDATE `Transaction` SET `Money` = :Money 
                        WHERE `NameID`= :NameID");
                    $UPth->bindParam(':Money', $data['Money'], PDO::PARAM_INT);
                    $UPth->bindParam(':NameID', $nameId );
                    $UPth->execute();

                    $data['OK'] = true;
                    $data['alert'] = "成功";

                } elseif ($moneyAction == "MoneyOUT") {
                    if ($data['Money'] >= $money) {
                        $data['Money'] = $data['Money'] - $money ;

                        $UPth = $dbh->prepare("UPDATE `Transaction` SET `Money` = :Money 
                            WHERE `NameID`= :NameID");
                        $UPth->bindParam(':Money', $data['Money'], PDO::PARAM_INT);
                        $UPth->bindParam(':NameID', $nameId );
                        $UPth->execute();

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
    function InsertGuestsRecord($nameId, $moneyAction, $money, $overMoney)  //帳戶 存取動作 交易金額 目前餘額
    {
        if ($moneyAction == "MoneyOUT") {
            $moneyOUT = $money;
            $moneyIN = "";
        }

        if ($moneyAction == "MoneyIN") {
            $moneyIN = $money;
            $moneyOUT = "";
        }

        $date= date("Y/m/d H:i:s");

        $dbh = $this->DBH ;
        $INth = $dbh->prepare("INSERT INTO `Record` (`NameID`,`Date`,`MoneyOUT`,`MoneyIN`,`Money`)
            VALUES (? , ?, ?, ?, ? )");
        $INth->bindParam(1, $nameId );
        $INth->bindParam(2, $date );
        $INth->bindParam(3, $moneyOUT );
        $INth->bindParam(4, $moneyIN );
        $INth->bindParam(5, $overMoney );
        $dbh = null;

        return $INth->execute();
    }

}
