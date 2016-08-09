<?php

class Controller {
    public function model($model) {
        require_once "../bank/models/$model.php";
        return new $model ();
    }

    
    public function view($view, $data = Array()) {
        $root = '/bank';     //位子重置
        $imgRoot = $root .'/views/';        //位子重置
        $cssRoot = $root .'/views/css';     //位子重置
        $jsRoot = $root .'/views/js';       //位子重置
        require_once "../bank/views/$view.php";
    }
}


