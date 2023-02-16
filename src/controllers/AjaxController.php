<?php
namespace src\controllers;
use \src\handlers\UserHandler;
use \core\Controller;
use src\handlers\PostHandler;

class AjaxController extends Controller {

    private $loggedUser;

        public function __construct(){
            $this->loggedUser = UserHandler::checkLogin();

            if ($this->loggedUser == false) {
                header("Content-Type: application/json");
                echo json_encode(['error' => 'Não logado']);
                exit;
            };        
        }

        public function like($atts){
            $id = $atts['id'];
            if (PostHandler::isLiked($id, $this->loggedUser->id)) {
               PostHandler::deleteLike($id, $this->loggedUser->id);
            } else {
                PostHandler::addLike($id, $this->loggedUser->id);
            };
        }

        public function comment(){
            $array = ['error' => ''];
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $txt = filter_input(INPUT_POST, 'txt', FILTER_SANITIZE_STRING);

            if ($id && $txt) {
                PostHandler::addComment($id, $txt, $this->loggedUser->id);

                $array['link'] = '/profile/' . $this->loggedUser->id;
                $array['avatar'] = '/media/avatars/' . $this->loggedUser->avatar;
                $array['body'] = $txt;
                $array['name'] = $this->loggedUser->nome;
            };

            header("Content-Type: application/json");
            echo json_encode($array);
            exit;
        }

        public function upload(){
            $array = ['error' => ''];

            if (isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])) {
                $photo = $_FILES['photo'];
                $maxWidth = 800;
                $maxHeight = 800;

                if (in_array($photo['type'], ['image/png', 'image/jpeg', 'image/jpg'])) {
                    list($widthOrig, $heightOrig) = getimagesize($photo['tmp_name']);
                    $ratio = $widthOrig/$heightOrig;

                    $newWidth = $maxWidth;
                    $newHeight = $maxHeight;

                    $ratioMax = $maxWidth/$maxHeight;

                    if ($ratioMax > $ratio) {
                       $newHeight = $newWidth * $ratio;
                    } else {
                        $newWidth = $newHeight/$ratio;
                    };

                    $finalImage = imagecreatetruecolor($newWidth, $newHeight);

                    switch ($photo['type']) {
                        case 'image/jpeg':
                            $image = imagecreatefromjpeg($photo['tmp_name']);
                            break;
                        case 'image/jpg':
                            $image = imagecreatefromjpeg($photo['tmp_name']);
                            break;
                        case 'image/png':
                            $image = imagecreatefrompng($photo['tmp_name']);
                            break;
                    };
        
                    imagecopyresampled($finalImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $widthOrig, $heightOrig);
                    $fileName = md5(time() . rand()) . '.jpg';
                    imagejpeg($finalImage, 'media/uploads/' .  $fileName);

                    PostHandler::addPost($this->loggedUser->id, 'photo', $fileName);

            } else{
                $array['error'] = 'Nenhuma imagem enviada!';
            };

            header("Content-Type: application/json");
            echo json_encode($array);
            exit;
        }
    }
}