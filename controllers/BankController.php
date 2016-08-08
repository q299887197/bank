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
        $NameID = $_POST['NameID'];
        $MoneyAction = $_POST['MoneyAction'];
        $Money = $_POST['Money'];
        
        $SelectName = $this->model("BankMoney");
        $result = $SelectName->SelectGuests($NameID);
        var_dump($result);
        exit;
        
    }
    
    
    ///=================================================================
    ////  顯示明細頁面
    ///=================================================================
    function Record(){
        $this->view("Record");
        
    } 
    
}

?>