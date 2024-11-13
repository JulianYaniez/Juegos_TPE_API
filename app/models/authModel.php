<?php
require_once './app/models/model.php';
require_once './app/controllers/authController.php';

class authModel extends model {
    
    public function __construct() {
        parent::__construct();
    }

    public function getUserByName($name) {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE nombre=?");
        $query->execute([$name]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}