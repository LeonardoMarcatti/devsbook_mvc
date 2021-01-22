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
            $data = User::select(['users.id as id',
            'users.nome as user_name',
            'users.passwd as passwd',
            'users.token as token',
            'emails.address as email',
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
                ->join('emails', 'users.id' , '=', 'emails.id_user')
                ->where('token', $token)
                ->one();

            if (count($data) > 0) {
               $loggeduser = new User();
               $loggeduser->id = $data['id'];
               $loggeduser->nome = $data['user_name'];
               $loggeduser->passwd = $data['passwd'];
               $loggeduser->email = $data['email'];
               $loggeduser->city = $data['city'];
               $loggeduser->work = $data['work'];
               $loggeduser->birthday = $data['birthday'];
               $loggeduser->avatar = $data['avatar'];
               $loggeduser->cover = $data['cover'];
               $loggeduser->token = $data['token'];

               return $loggeduser;
            };
        };

        return false;
    }

    public static function verifyLogin($email, $passwd){
        $id_user = Email::select(['id_user'])->where('address', $email)->one();

        if ($id_user) {
            $user = User::select()->where('id', $id_user)->one();
        }else{
            return false;
        };        

        if ($user) {
            if (password_verify($passwd, $user['passwd'])) {
                $token = md5(rand() . time());
                User::update()->set('token', $token)->where('id', $id_user['id_user'])->execute();
                return $token;
            };
        };

        return false;
    }

    public static function searchUsers($term){
        $data = User::select(['users.id as id',
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
            ->where('users.nome', 'like', '%'.$term.'%')
        ->get();
        return $data;       
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
                    'emails.address as email',
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
                    ->join('emails', 'users.id' , '=', 'emails.id_user')
                    ->where('users.id', $id)
        ->one();

        if ($user_data) {
            $user = new User();
            $user->id = $user_data['id'];
            $user->name = $user_data['user_name'];
            $user->email = $user_data['email'];
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

                $followers = Relation::select()->where('user_to', $id)->get();

                foreach ($followers as $key => $value) {
                    $followers_data = User::select()->where('id', $value['user_from'])->one();

                    $follower = new User();
                    $follower->id = $followers_data['id'];
                    $follower->name = $followers_data['nome'];
                    $follower->avatar = $followers_data['avatar'];

                    $user->followers[] = $follower;
                };

                $following = Relation::select()->where('user_from', $id)->get();

                foreach ($following as $key => $value) {
                    $following_data = User::select()->where('id', $value['user_to'])->one();

                    $following_user = new User();
                    $following_user->id = $following_data['id'];
                    $following_user->name = $following_data['nome'];
                    $following_user->avatar = $following_data['avatar'];

                    $user->following[] = $following_user;
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
        if ($check) {
            return true;
        } else {
            return false;
        };        
    }

    public static function follow($from, $to){
        Relation::insert(['user_from' => $from, 'user_to' => $to])->execute();
    }

    public static function unfollow($from, $to){
        Relation::delete()->where('user_from', $from)->where('user_to', $to)->execute();
    }

    public static function updateUser($id, $name, $birthday, $email, $city, $work, $passwd, $avatar, $cover){
        $checked_city = City::select()->where('nome', $city)->one();
        $updated = [];

        if (!$checked_city) {
            City::insert(['nome' => $city])->execute();
            $checked_city = City::select()->where('nome', $city)->one();
        };

        $checked_work = Work::select()->where('nome', $work)->one();

        if (!$checked_work) {
            Work::insert(['nome' => $work])->execute();
            $checked_work = Work::select()->where('nome', $work)->one();
        };

        $hash = password_hash($passwd, PASSWORD_BCRYPT);

        if ($avatar != '' && $cover != '') {
            User::update()
            ->set('nome', $name)
            ->set('birthday', $birthday)
            ->set('id_city', $checked_city['id'])
            ->set('id_work', $checked_work['id'])
            ->set('avatar', $avatar)
            ->set('cover', $cover)
            ->where('id', $id)
        ->execute();
        } else if($avatar != '' && $cover == ''){
            User::update()
            ->set('nome', $name)
            ->set('birthday', $birthday)
            ->set('id_city', $checked_city['id'])
            ->set('id_work', $checked_work['id'])
            ->set('avatar', $avatar)
            ->where('id', $id)
        ->execute();
        } else if($avatar == '' && $cover != ''){
            User::update()
            ->set('nome', $name)
            ->set('birthday', $birthday)
            ->set('id_city', $checked_city['id'])
            ->set('id_work', $checked_work['id'])
            ->set('cover', $cover)
            ->where('id', $id)
        ->execute();
        } else {
            User::update()
            ->set('nome', $name)
            ->set('birthday', $birthday)
            ->set('id_city', $checked_city['id'])
            ->set('id_work', $checked_work['id'])
            ->where('id', $id)
        ->execute();
        }       
       
        if ($passwd != '') {
            User::update()
                ->set('passwd', $hash)
                ->where('id', $id)
            ->execute();  
        };

        Email::update()
            ->set('address', $email)
            ->where('id_user', $id)
            ->execute();

    }


};