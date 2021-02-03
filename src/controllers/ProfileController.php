<?php
    namespace src\controllers;
    use \core\Controller;
    use \src\handlers\UserHandler;
    use \src\handlers\PostHandler;

    class ProfileController extends Controller {

        private $loggedUser;

        public function __construct(){
            $this->loggedUser = UserHandler::checkLogin();

            if ($this->loggedUser == false) {
                $this->redirect('/login');
            };        
        }

        public function index($attrs = []) {
            $page = intval(filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT));

            //Detecting the accessed user
            $id = $this->loggedUser->id;
            if (!empty($attrs['id'])) {
                $id = $attrs['id'];
            };

            //Get intel about the user
            $user = UserHandler::getUser($id, true);

            if (!$user) {
                $this->redirect('/');
            };
            
            //Geting user feed
            $feed = PostHandler::getUserFeed($id, $page, $this->loggedUser->id);

            //Check if I follow the accessed user
            $isFollowing = false;
            if ($user->id != $this->loggedUser->id) {
                $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
            };
            
            $this->render('profile', ['loggedUser' => $this->loggedUser, 'user' => $user, 'feed' => $feed, 'isFollowing' => $isFollowing]);
        }

        public function follow($attrs){
            $to = intval($attrs['id']);

            if (UserHandler::idExists($attrs['id'])) {
                if (UserHandler::isFollowing($this->loggedUser->id, $attrs['id'])) {
                   UserHandler::unfollow($this->loggedUser->id, $attrs['id']);
                } else {
                    UserHandler::follow($this->loggedUser->id, $attrs['id']);
                };
                
            };

            $this->redirect('/profile/' . $to);
        }

        public function friends($attrs = []){
            $id = $this->loggedUser->id;

            if (!empty($attrs['id'])) {
                $id = $attrs['id'];
            };

            $user = UserHandler::getUser($id, true);

            if (!$user) {
                $this->redirect('/');
            };

            $isFollowing = false;
            if ($user->id != $this->loggedUser->id) {
                $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
            };

            $this->render('friends', ['loggedUser' => $this->loggedUser, 'user' => $user, 'isFollowing' => $isFollowing]);
            
        }

        public function photos($attrs = []){
            $id = $this->loggedUser->id;

            if (!empty($attrs['id'])) {
                $id = $attrs['id'];
            };

            $user = UserHandler::getUser($id, true);

            if (!$user) {
                $this->redirect('/');
            };

            $isFollowing = false;
            if ($user->id != $this->loggedUser->id) {
                $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
            };

            $this->render('photos', ['loggedUser' => $this->loggedUser, 'user' => $user, 'isFollowing' => $isFollowing]);
            
        }

        public function config(){
            $this->render('config', ['config' => 'config', 'loggedUser' => $this->loggedUser]);
        }

        public function configAction(){
            $id = $this->loggedUser->id;
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
            $work = filter_input(INPUT_POST, 'work', FILTER_SANITIZE_STRING);
            $passwd = filter_input(INPUT_POST, 'pass1', FILTER_SANITIZE_STRING);

            //Avatar
            
            #Verifica se foi enviado algo
            if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])) {
                $newAvatar = $_FILES['avatar'];
                #verifica o tipo de arquivo aceito
                if (in_array($newAvatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
                    $avatarName = $this->cutImage($newAvatar, 200, 200, 'media/avatars');
                };
            };

            //Cover

            #Verifica se foi enviado algo
            if (isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])) {
                $newCover = $_FILES['cover'];
                #verifica o tipo de arquivo aceito
                if (in_array($newCover['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
                    $coverName = $this->cutImage($newCover, 850, 310, 'media/covers'); 
                };
            };

            UserHandler::updateUser($id, $name, $birthday, $email, $city, $work, $passwd, $avatarName, $coverName);

            $this->redirect('/profile');
           
        }

        public function cutImage($file, $w, $h, $folder){
            list($widthOrginal, $heightOrginal) = getimagesize($file['tmp_name']);

            #Os cálculos a seguir fazem com que a altura e largura estejam de acordo com o desejado (200x200 ou 850x310)
            $ratio = $widthOrginal / $heightOrginal;
            $newWidth = $w;
            $newHeight = $newWidth / $ratio;

            if ($newHeight < $h) {
                $newHeight = $h;
                $newWidth = $newHeight * $ratio;
            };

            $x = $w - $newWidth;
            $y = $h - $newHeight;

            $x = ($x < 0)? $x/2 : $x;
            $y = ($y < 0)? $y/2 : $y;

            $finalImage = imagecreatetruecolor($w, $h);

            switch ($file['type']) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($file['tmp_name']);
                    break;
                case 'image/jpg':
                    $image = imagecreatefromjpeg($file['tmp_name']);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($file['tmp_name']);
                    break;
            };

            imagecopyresampled($finalImage, $image, $x, $y, 0, 0, $newWidth, $newHeight, $widthOrginal, $heightOrginal);
            $fileName = md5(time() . rand()) . '.jpg';
            imagejpeg($finalImage, $folder . '/' .  $fileName);

            return $fileName;

        }
    };

?>