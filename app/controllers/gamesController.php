<?php

require_once './app/models/gamesModel.php';
require_once './app/views/JSONView.php';

class gamesController {
    private $model;
    private $view;

    public function __construct(){
        $this->model = new gamesModel();
        $this->view = new JSONView();
    }

    
}