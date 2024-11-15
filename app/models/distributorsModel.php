<?php

require_once './app/models/model.php';
require_once './app/controllers/gamesController.php';

class distributorsModel extends model {

    public function __construct(){
        parent::__construct();
    }
    public function getDistributorById($id){

        $query = $this->db->prepare("SELECT * FROM distribuidoras WHERE id=?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}