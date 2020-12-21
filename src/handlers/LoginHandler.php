<?php
namespace src\handlers;

use \src\models\User;
use \src\models\Email;

class LoginHandler{
    public static function checkLogin(){
        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];
            $data = User::select()->where('token', $token)->one();

            if (count($data) > 0) {
               $loggeduser = new User();
               $loggeduser->id = $data['id'];
               $loggeduser->nome = $data['nome'];
               $loggeduser->passwd = $data['passwd'];
               $loggeduser->birthday = $data['birthday'];
               $loggeduser->avatar = $data['avatar'];
               $loggeduser->cover = $data['cover'];
               $loggeduser->token = $data['token'];
               $loggeduser->work = $data['id_work'];
               $loggeduser->city = $data['id_city'];

               return $loggeduser;
            };
        };

        return false;
    }

    public static function verifyLogin($email, $passwd){
        $id_user = Email::select()->where('address', $email)->one();
        $user = User::select()->where('id', $id_user['id_user'])->one();

        if ($user) {
            if (password_verify($passwd, $user['passwd'])) {
                $token = md5(rand() . time());
                User::update()->set('token', $token)->where('id', $id_user['id_user'])->execute();
                return $token;
            };
        };

        return false;
    }

    public static function emailExists($email){
        $data = Email::select()->where('address', $email)->one();
        return ($data)? $data : false;
    }

    public static function addUser($name, $email, $birthday, $passwd){
        $hash = password_hash($passwd, PASSWORD_BCRYPT);
        $token = md5(rand() . time());

        User::insert([
            'nome' => $name,
            'passwd' => $hash,
            'birthday' => $birthday,            
            'avatar' => 'avatar.jpg',
            'cover' => 'cover.jpg',
            'token' => $token
        ])->execute();

        $lastAdded = User::select()->max('id');

        Email::insert(['address' => $email, 'id_user' => $lastAdded])->execute();

        return $token;
    }

};