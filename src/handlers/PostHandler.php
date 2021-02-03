<?php
    namespace src\handlers;

    use \src\models\Post;
    use \src\models\User;
    use \src\models\Relation;
    use \src\models\Like;
    use \src\models\Comment;

    class PostHandler{
        public static function addPost($id, $type, $body){
            Post::insert([
                'post_type' => $type,
                'created_at' => date('Y-m-d H:i:s'),
                'body' => $body,
                'id_user' => $id
            ])->execute();
        }

        public static function postList_To_Object($post_list, $loggedUser){
            $posts = [];

            foreach ($post_list as $key => $value) {
                $newPost = new Post();
                $newPost->id = $value['id'];
                $newPost->type = $value['post_type'];
                $newPost->created_at = $value['created_at'];
                $newPost->body = $value['body'];
                $newPost->id_user = $value['id_user'];
                $newPost->mine = false;

                if ($value['id_user'] == $loggedUser) {
                    $newPost->mine = true;
                };


                #Get addicional infos
                $newUser = User::select()->where('id', $value['id_user'])
                ->one();

                $newPost->user = new User();
                $newPost->user->id = $newUser['id'];
                $newPost->user->name = $newUser['nome'];
                $newPost->user->birthday = $newUser['birthday'];
                $newPost->user->avatar = $newUser['avatar'];
                $newPost->user->cover = $newUser['cover'];
                $newPost->user->id_city = $newUser['id_city'];
                $newPost->user->id_work = $newUser['id_work'];

                #Info about likes
                $likes = Like::select()->where('id_post', $value['id'])->get();
                
                $newPost->likeCount = count($likes);
                $newPost->liked = self::isLiked($value['id'], $loggedUser);
                #Info about comments
                $newPost->comments = Comment::select()->where('id_post', $value['id'])->get();
                
                foreach ($newPost->comments as $key => $value) {
                    $newPost->comments[$key]['user'] = User::select()->where('id', $value['id_user'])->one();
                };
                $posts[] = $newPost;
            };

            return $posts;
        }

        public static function isLiked($id, $loggedUser){
            $liked = Like::select()->where('id_post', $id)->where('id_user', $loggedUser)->get();
            
            return (count($liked) > 0)? true : false;
        }

        public static function deleteLike($id, $loggedUser){
            Like::delete()->where('id_post', $id)->where('id_user', $loggedUser)->execute();
        }

        public static function addLike($id, $loggedUser){
            Like::insert([
                    'id_post' => $id,
                    'id_user' => $loggedUser,
                    'created_at' => date('Y-m-d H:i:s')
                ])
            ->execute();

            echo 'ok';
        }

        public static function addComment($id, $txt, $loggedUserID){
            Comment::insert(['id_post' => $id, 'body' => $txt, 'id_user' => $loggedUserID, 'created_at' => date('Y-m-d H:i:s')])->execute();
        }

        public static function getUserFeed($id, $page, $loggedUser){
            $perPage = 2;
            $post_list = Post::select()->where('id_user', $id)
                        ->orderBy('created_at', 'desc')
                        ->page($page, $perPage)
            ->get();

            $total = Post::select()->where('id_user', $id)
            ->count();

            $pageCount = ceil($total / $perPage);
            
            #Make every post a object
            $posts = self::postList_To_Object($post_list, $loggedUser);
            
            #Return the results
            return ['posts' => $posts, 'pageCount' => $pageCount, 'currentPage' => $page];
        }

        public static function getHomeFeed($id, $page){
            $perPage = 2;
            #Get list of followed users 
            $user_list = Relation::select()
                        ->where('user_from', $id)
            ->get();
            $users = [];

            foreach ($user_list as $key => $value) {
                $users[] = $value['user_to'];
            };

            $users[] = $id;

            #Get posts from each user in the list orderred by date/time
            $post_list = Post::select()->where('id_user', 'in', $users)
                        ->orderBy('created_at', 'desc')
                        ->page($page, $perPage)
            ->get();

            $total = Post::select()->where('id_user', 'in', $users)
            ->count();

            $pageCount = ceil($total / $perPage);
            
            #Make every post a object
            $posts = self::postList_To_Object($post_list, $id);
            
            #Return the results
            return ['posts' => $posts, 'pageCount' => $pageCount, 'currentPage' => $page];
        }

        public static function getUserPhotos($id){
            $data = Post::select()->where('id_user', $id)->where('post_type','photo')->get();
            $photos = [];

            if (count($data) > 0) {
                foreach ($data as $key => $value) {
                    $newPhoto = new Post();
                    $newPhoto->id = $value['id'];
                    $newPhoto->type = $value['post_type'];
                    $newPhoto->created_at = $value['created_at'];
                    $newPhoto->body = $value['body'];
    
                    $photos[] = $newPhoto;
                };
            };

            return $photos;

        }

        public static function delete($idPost, $idUser){
            // Check if the post belong to the user who is tring to delete it
            $post = Post::select()->where('id', $idPost)->where('id_user', $idUser)->one();
            if ($post) {
                like::delete()->where('id_post', $post['id'])->execute();
                Comment::delete()->where('id_post', $post['id'])->execute();
                Post::delete()->where('id', $post['id'])->where('id_user', $idUser)->execute();
                if ($post['post_type'] == 'photo') {
                    $img = 'media/uploads/' . $post['body'];
                    if (file_exists($img)) {
                        unlink($img);
                    };
                };
            };
            var_dump($post);
        }
    };

?>