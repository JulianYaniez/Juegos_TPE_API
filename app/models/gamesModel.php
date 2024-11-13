<?php

require_once './app/models/model.php';
require_once './app/controllers/gamesController.php';

class gamesModel extends model {

    public function __construct(){
        parent::__construct();
    }

    public function getGames($page, $limit, $sortBy = null, $order = 'ASC'){
        $validColumns = ['titulo', 'genero', 'id_distribuidora', 'precio', 'fecha_salida'];
        $sql = "SELECT * FROM juegos";
    
        if ($sortBy && in_array($sortBy, $validColumns)) {
            $sql .= " ORDER BY $sortBy " . ($order == 'DESC' ? 'DESC' : 'ASC');
        }
    
        if ($limit != NULL) {
            $sql .= ' LIMIT ' . $limit;
        }
        if ($page != NULL && $limit != NULL) {
            $offset = ($page - 1) * $limit;
            $sql .= ' OFFSET ' . $offset;
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
    public function createGame($title, $genre, $distributor, $price, $date){
        $query = $this->db->prepare("INSERT INTO juegos(titulo, genero, id_distribuidora, precio, fecha_salida) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$title, $genre, $distributor, $price, $date]);
        
        return $this->db->lastInsertId();
    }
    public function updateGame($id, $title, $genre, $distributor, $price, $date){
        $query = $this->db->prepare("UPDATE juegos SET titulo=?,genero=?,id_distribuidora=?,precio=?,fecha_salida=? WHERE id = ?");
        $query->execute([$title, $genre, $distributor, $price, $date, $id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function deleteGame($id){
        $query = $this->db->prepare("DELETE FROM juegos WHERE id = ?");
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