<?php

class BankController extends Controller
{
    
    
    ///=================================================================
    ////  顯示出入款頁面
    ///=================================================================
    function Transaction(){
        $this->view("Transaction");
        
    }
    
    function Transactioning(){
        $Bank = $this->model("BankMoney");
        
        // 帳戶  存取動作  交易金額
        $GuestsMoney = $Bank->SelectGuests($_POST['NameID'], $_POST['MoneyAction'] ,$_POST['Money']);  //查詢到帳號的餘額
        
        // 帳戶  存取動作  交易金額  目前餘額
        $InsertRecord = $Bank->InsertGuestsRecord($_POST['NameID'],$_POST['MoneyAction'],$_POST['Money'],$GuestsMoney['Money']); 
        
        // var_dump($InsertRecord);
        // exit;
        $this->view("Transaction",$GuestsMoney);
        
    }
    
    
    ///=================================================================
    ////  顯示明細頁面
    ///=================================================================
    function Record(){
        $this->view("Record");
        
    } 
    
}

?>