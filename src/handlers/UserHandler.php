<?php
namespace src\handlers;

use DateTime;
use \src\models\User;
use \src\models\Email;
use \src\models\City;
use \src\models\Work;
use \src\models\Relation;
use \src\handlers\PostHandler;

class UserHandler{
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

    public static function idExists($id){
        $data = Email::select()->where('id_user', $id)->one();
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

    public static function getUser($id, $full = false){
        $user_data = User::select(['users.id as id',
                    'users.nome as user_name',
                    'users.birthday as birthday',
                    'users.avatar as avatar',
                    'users.cover as cover',
                    'users.id_city as id_city',
                    'users.id_work as id_work',
                    'works.nome as work',
                    'citys.nome as city' 
                    ])
                    ->join('works', 'users.id_work', '=', 'works.id')
                    ->join('citys', 'users.id_city', '=', 'citys.id')
                    ->where('users.id', $id)
        ->one();

        if ($user_data) {
            $user = new User();
            $user->id = $user_data['id'];
            $user->name = $user_data['user_name'];
            $user->birthday = $user_data['birthday'];
            $birth = new DateTime($user_data['birthday']);
            $today = new DateTime('today');
            $user->age = $birth->diff($today)->y;
            $user->avatar = $user_data['avatar'];
            $user->cover = $user_data['cover'];
            $user->id_city = $user_data['id_city'];
            $user->id_work = $user_data['id_work'];
            $user->city = $user_data['city'];
            $user->work = $user_data['work'];

            if ($full) {
                $user->followers = [];
                $user->following = [];
                $user->photos = [];

                $followers = Relation::select(['user_from'])->where('user_to', $id)->get();

                foreach ($followers as $key => $value) {
                    $user_data = User::select()->where('id', $value['id'])->one();

                    $new_user = new User();
                    $new_user->id = $user_data['id'];
                    $new_user->name = $user_data['nome'];
                    $new_user->avatar = $user_data['avatar'];

                    $followers[] = $new_user;
                };

                $following = Relation::select(['user_to'])->where('user_from', $id)->get();

                foreach ($following as $key => $value) {
                    $user_data = User::select()->where('id', $value['id'])->one();

                    $new_user = new User();
                    $new_user->id = $user_data['id'];
                    $new_user->name = $user_data['nome'];
                    $new_user->avatar = $user_data['avatar'];

                    $following[] = $new_user;
                };

                //Photos
                $user->photos = PostHandler::getUserPhotos($id);

            };

            return $user;
        };

        return false;
    }

    public static function isFollowing($from, $to){
        $check = Relation::select()->where('user_from', $from)->where('user_to', $to)->one();
        //return ($check) ? true : false;
        if ($check) {
            return true;
        } else {
            return false;
        };        
    }

};