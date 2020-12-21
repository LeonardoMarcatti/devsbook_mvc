<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;

class LoginController extends Controller {

    public function login(){
        $flash = '';
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
       $this->render('login', ['flash' => $flash]);
    }

    public function logup(){
        $flash = '';
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
       $this->render('logup', ['flash' => $flash]);
    }

    public function loginAction(){
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $passwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if ($email && $passwd) {
           $token = LoginHandler::verifyLogin($email, $passwd);

           if ($token) {
               $_SESSION['token'] = $token;
               $this->redirect('/');
           }else{
                $_SESSION['flash'] = 'Email e/ou senha não conferem';
                $this->redirect('/login');
           };

        } else {
            $_SESSION['flash'] = 'Digite email e senha.';
            $this->redirect('/login');
        };
        
    }

    public function logupAction(){
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING);
        $passwd = filter_input(INPUT_POST, 'passwd1', FILTER_SANITIZE_STRING);

        if ($name && $email && $birthday && $passwd) {
            if (LoginHandler::emailExists($email) == false) {
               $token =  LoginHandler::addUser($name, $email, $birthday, $passwd);
               $_SESSION['token'] = $token;
               $this->redirect('/');
            } else{
                $_SESSION['flash'] = 'Email já em uso.';
                $this->redirect('/logup');
            };
        } else {
            $this->redirect('/logup');
        };
        
        
        
    }

}