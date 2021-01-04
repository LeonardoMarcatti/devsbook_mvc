<?php
    namespace src\controllers;
    use \core\Controller;
    use \src\handlers\PostHandler;
    use \src\handlers\UserHandler;

    class PostController extends Controller {

        private $loggedUser;

        public function __construct(){
            $this->loggedUser = UserHandler::checkLogin();

            if ($this->loggedUser == false) {
                $this->redirect('/login');
            };        
        }

        public static function trimWithEntities(string $string){

            return trim(str_replace("&nbsp;", "", $string));
        }

        public function new() {
            $body = filter_input(INPUT_POST, 'body');
            $body = self::trimWithEntities($body);

            if ($body) {
                $post = PostHandler::addPost($this->loggedUser->id, $type = 'text', $body);
            };
            
            $this->redirect('/');
        }

    };

?>