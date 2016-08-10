<?php

class Controller
{
    public function model($model)
    {
        require_once "../bank/models/$model.php";
        return new $model();
    }

    public function view($view, $data = Array())
    {
        $root = '/bank';
        $imgRoot = $root .'/views/';
        $cssRoot = $root .'/views/css';
        $jsRoot = $root .'/views/js';

        require_once "../bank/views/$view.php";
    }
}
