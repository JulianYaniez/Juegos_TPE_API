<?php

require_once './app/models/gamesModel.php';
require_once './app/views/JSONView.php';
require_once './app/models/distributorsModel.php';


class gamesController {
    private $model;
    private $view;
    private $modelD;

    public function __construct(){
        $this->model = new gamesModel();
        $this->view = new JSONView();
        $this->modelD = new distributorsModel();
    }

    public function getGames($req, $res){
        $page = $req->query->pagina ?? null;
        $limit = $req->query->limite ?? null;
        $sortBy = $req->query->ordenarPor ?? null;
        $order = $req->query->orden ?? 'ASC';
    
        if(isset($req->params->id)){
            $id = $req->params->id;
            $game = $this->model->getGameById($id);
    
            if(!$game){
                return $this->view->response("El juego con el id= $id no existe", 404);
            }
            return $this->view->response($game, 200);
        }
        
        if(isset($req->query->criterios) || (isset($req->query->valor) && is_numeric($req->query->valor))){
            return $this->filter($req, $res);
        }
        if(($page <= 0 && $page != NULL) || ($limit <= 0 && $limit != NULL)) {
            return $this->view->response("Error en los valores de la paginacion y limite", 400);
        }

        $games = $this->model->getGames($page, $limit, $sortBy, $order);
    
        if (!$games) {
            return $this->view->response('No hay juegos disponibles', 404);
        }
    
        return $this->view->response($games, 200);
    }
    
    public function createGame($req,$res){

        if($res->user == NULL){
            return $this->view->response('No estas logueado', 401);
        }
        if(!isset($req->body->titulo) || !isset($req->body->genero) || !isset($req->body->id_distribuidora) || !isset($req->body->precio) || !isset($req->body->fecha_salida)){
            return $this->view->response('falta completar campos', 400);
        }
        $title = $req->body->titulo;
        $genre = $req->body->genero;
        $distributor = $req->body->id_distribuidora;
        $price = $req->body->precio;
        $date = $req->body->fecha_salida;

        if(!$this->modelD->getDistributorById($distributor)){
            return $this->view->response('El distribuidor con el id= ' . $distributor . ' no existe', 404);
        }

        $id = $this->model->createGame($title, $genre, $distributor, $price, $date);
        if(!$id){
            $this->view->response('No se pudo crear el juego', 500);
        }

        $game = $this->model->getGameById($id);
        $this->view->response($game, 201);
    }
    public function updateGame($req, $res){
        if($res->user == NULL){
            return $this->view->response('No estas logueado', 401);
        }
        $id = $req->params->id;
        $game = $this->model->getGameById($id);

        if(!$game){
            return $this->view->response("El juego con el id= $id no existe", 404);
        }

        if(!isset($req->body->titulo) || !isset($req->body->genero) || !isset($req->body->id_distribuidora) || !isset($req->body->precio) || !isset($req->body->fecha_salida)){
            return $this->view->response('falta completar campos', 400);
        }

        $title = $req->body->titulo;
        $genre = $req->body->genero;
        $distributor = $req->body->id_distribuidora;
        $price = $req->body->precio;
        $date = $req->body->fecha_salida;

        if(!$this->modelD->getDistributorById($distributor)){
            return $this->view->response('El distribuidor con el id= ' . $distributor . ' no existe', 404);
        }

        $this->model->updateGame($id, $title, $genre, $distributor, $price, $date);

        $game = $this->model->getGameById($id);
        $this->view->response($game, 200);
    }
    public function deleteGame($req, $res){

        if($res->user == NULL){
            return $this->view->response("No estas logueado", 401);
        }
        $id = $req->params->id;

        $game = $this->model->getGameById($id);

        if(!$game){
            return $this->view->response("El juego con el id= $id no existe", 404);
        }
        $this->view->response("El juego con el id= $id ha sido eliminado", 200);
        return $this->model->deleteGame($id);
    }
    public function filter($req, $res) {
        $criterio = $req->query->criterio;
        $valor = $req->query->valor;
        if(!$criterio || !$valor){
            return $this->view->response('falta asignarle un valor a las querys', 400);
        }

        $games = $this->model->filter($criterio, $valor);

        if(!$games){
            return $this->view->response('No existen juegos con el filtro seleccionado', 404);
        }

        $this->view->response($games, 200);
    }
}