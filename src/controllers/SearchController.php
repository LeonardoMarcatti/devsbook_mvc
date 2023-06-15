<?php
    namespace src\controllers;
    use \core\Controller;
    use \src\handlers\UserHandler;
    use \src\handlers\PostHandler;
    use \src\models\User;

    class SearchController extends Controller {

        private $loggedUser;

        public function __construct(){
            $this->loggedUser = UserHandler::checkLogin();

            if ($this->loggedUser == false) {
                $this->redirect('/login');
            };        
        }

        public function index($attrs = []) {
            $search_term = filter_input(INPUT_GET, 's', \FILTER_SANITIZE_SPECIAL_CHARS);

            if (empty($search_term)) {
                $this->redirect('/');
            };

            $data = UserHandler::searchUsers($search_term);
            
            if (count($data) > 0) {
                $users = [];
                foreach ($data as $key => $value) {
                   $newUser = new User();
                   $newUser->id = $value['id'];
                   $newUser->name = $value['user_name'];
                   $newUser->avatar = $value['avatar'];

                   $users[] = $newUser;
                };

                $this->render('search', ['loggedUser' => $this->loggedUser, 'users' => $users]);
            };

            $this->redirect('/');            
        }

        
    };

?>