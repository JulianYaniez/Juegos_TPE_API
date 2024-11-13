<?php
require_once './app/views/JSONView.php';
require_once './app/models/authModel.php';
require_once './libs/jwt.php';

class authController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new authModel();
        $this->view = new JSONView();
    }

    public function getToken($req, $res) {
        $auth_header = $_SERVER['HTTP_AUTHORIZATION'];
        $auth_header = explode(' ', $auth_header);

        if(count($auth_header) != 2 || $auth_header[0] != 'Basic') {
            return $this->view->response("Error en los datos ingresados", 400);
        }   

        $user_pass = base64_decode($auth_header[1]);
        $user_pass = explode(':', $user_pass);

        $user = $this->model->getUserByName($user_pass[0]);

        if($user == null) {
            return $this->view->response("Error en el usuario", 400);
        }
        if(!password_verify($user_pass[1], $user->contraseña)){
            return $this->view->response("Error en la contraseña", 400);
        }
        $token = createJWT(array(
            'name' => $user->nombre,
            'role' => 'admin',
            'iat' => time(),
            'exp' => time() + 6000,
            'Saludo' => 'Hola',
        ));
        return $this->view->response($token, 200);
    }
}