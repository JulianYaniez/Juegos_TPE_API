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

    public function getGames($req, $res){
        $page = null;
        $limit = null;
        
        if(isset($req->params->id)){
            $id = $req->params->id;

            $game = $this->model->getGameById($id);

            if(!$game){
                return $this->view->response("El juego con el id= $id no existe", 404);
            }
            return $this->view->response($game, 200);
        }
        if(isset($req->query->criterios) || isset($req->query->valor)){
            return $this->filter($req, $res);
        }
        if(isset($Req->query->pagina) || isset($req->query->limite)){
            $page = $req->query->pagina;
            $limit = $req->query->limite;
            $games = $this->model->getGames($page, $limit);

            if(!$games){
                return $this->view->response('No hay juegos en la pagina y/o limite seleccionados', 404);
            }
            return $this->view->response($games, 200);
        }
        $games = $this->model->getGames($page, $limit);
        return $this->view->response($games, 200);
    }
    public function createGame($req,$res){

        if($res->user == NULL){
            $this->view->response('No estas logueado', 401);
        }
        if(!isset($req->body->titulo) || !isset($req->body->genero) || !isset($req->body->id_distribuidora) || !isset($req->body->precio) || !isset($req->body->fecha_salida)){
            return $this->view->response('falta completar campos', 400);
        }
        $title = $req->body->titulo;
        $genre = $req->body->genero;
        $distributor = $req->body->id_distribuidora;
        $price = $req->body->precio;
        $date = $req->body->fecha_salida;

        $id = $this->model->createGame($title, $genre, $distributor, $price, $date);
        if(!$id){
            $this->view->response('No se pudo crear el juego', 500);
        }

        $game = $this->model->getGameById($id);
        $this->view->response($game, 200);
    }
    public function updateGame($req, $res){
        if($res->user == NULL){
            $this->view->response('No estas logueado', 401);
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