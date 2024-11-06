<?php

require_once './app/models/model.php';
require_once './app/controllers/gamesController.php';

class gamesModel extends model {

    public function __construct(){
        parent::__construct();
    }

    public function getGames($page, $limit){
        $sql = "SELECT * FROM juegos";

        if($limit != NULL){
            $sql .= ' LIMIT ' . $limit;
        }
        if($page != NULL){
            $sql .= ' OFFSET ' . $page;
        }
        $query = $this->db->prepare($sql);
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
    public function deleteGame($id){
        $query = $this->db->prepare("DELETE * FROM juegos WHERE id = ?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function filter($criterio, $valor){
        
        $sql = 'SELECT * FROM juegos WHERE ';

        if($criterio == 'distribuidora'){
            $sql .= 'id_distribuidora = ?';
        }
        switch($criterio){
            case'mayor':
                $sql .= 'precio > ?';
                break;
            case'menor':
                $sql .= 'precio < ?';
                break;
            case'igual':
                $sql .= 'precio = ?';
                break;
        }
        $query = $this->db->prepare($sql);
        $query->execute([$valor]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}