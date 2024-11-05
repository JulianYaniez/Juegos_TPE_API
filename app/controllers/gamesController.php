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
        $games = $this->model->getGames();
        return $this->view->response($games, 200);
    }
    public function updateGame($req, $res){
        $id = $req->params->id;
        $game = $this->model->getGameById($id);

        if(!$game){
            return $this->view->response("El juego con el id= $id no existe", 404);
        }
        if(!isset($req->body->title) || !isset($req->body->genre) || !isset($req->body->genre) || !isset($req->body->genre) || !isset($req->body->genre)){
            return $this->view->response('falta completar campos', 400);
        }

        $title = $req->body->title;
        $genre = $req->body->genre;
        $distributor = $req->body->distributor;
        $price = $req->body->price;
        $date = $req->body->date;

        $this->model->updateGame($id, $title, $genre, $distributor, $price, $date);

        $game = $this->model->getGameById($id);
        $this->view->response($game, 200);
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