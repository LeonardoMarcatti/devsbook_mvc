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


    };

?>