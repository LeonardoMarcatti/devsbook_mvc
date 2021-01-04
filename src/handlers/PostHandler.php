<?php
    namespace src\handlers;

    use \src\models\Post;
    use \src\models\User;
    use \src\models\Relation;

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
                $newPost->likeCount = 0;
                $newPost->liked = false;
                #Info about comments
                $newPost->comments = [];

                $posts[] = $newPost;
            };

            return $posts;
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
    };

?>