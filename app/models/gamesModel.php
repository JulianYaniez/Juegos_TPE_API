<?php

require_once './app/models/model.php';
require_once './app/controllers/gamesController.php';

class gamesModel extends model {

    public function __construct(){
        parent::__construct();
    }

    public function getGames(){

        $query = $this->db->prepare("SELECT * FROM juegos");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getGameById($id){

        $query = $this->db->prepare("SELECT * FROM juegos WHERE id=?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function updateGame($id, $title, $genre, $distributor, $price, $date){
        $query = $this->db->prepare("UPDATE juegos SET id=?,titulo=?,genero=?,id_distribuidora=?,precio=?,fecha_salida=? WHERE 1");
        $query->execute([$id, $title, $genre, $distributor, $price, $date]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function filter($criterio, $valor){
        
        $sql = 'SELECT * FROM juegos WHERE ';

        switch($criterio){
            case'mayor':
                $sql .= '> ?';
                break;
            case'menor':
                $sql .= '< ?';
                break;
            case'igual':
                $sql .= '= ?';
                break;
        }
        $query = $this->db->prepare($sql);
        $query->execute([$valor]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}