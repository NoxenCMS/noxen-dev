<?php
        $urlBuilder = $this->urlBuilder;
        $connection = $this->database->connection();
        $isLoggedIn = $this->gatekeeper->isLoggedIn();
        $moderator = 0;
        $loggedGroup = 0;
        if($isLoggedIn == 1){
            $loggedUser = $this->gatekeeper->getUser();
            $loggedUserId = $loggedUser->id;
            $loggedGroupCon = $connection->first('SELECT * FROM groups_users WHERE user_id = ?', [$loggedUserId]);
            if($loggedGroupCon == ""){
                $loggedGroupID = 0;
                $loggedGroup = 0;
            } else {
                $loggedGroupID = $loggedGroupCon->group_id;
                $loggedGroup = $connection->first('SELECT * FROM groups WHERE id = ?', [$loggedGroupID]);
                if($loggedGroup->moderator == 1){
                    $moderator = 1;
                } else {
                    $moderator = 0;
                }
            }
            
        } else {
            $loggedUser = "User is not logged in";
        }

        /* GET SERVER DATA */
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        $users = $connection->all('SELECT * FROM users');
        $posts = $connection->all('SELECT * FROM posts ORDER BY id DESC');
        $groups = $connection->all('SELECT * FROM groups');
        $groups_users = $connection->all('SELECT * FROM groups_users');
        $footer = $connection->first('SELECT * FROM footer');
        $pages = $connection->all('SELECT * FROM pages');
        
        $noxen_data = array(
            'urlBuilder' => $urlBuilder,
            'connection' => $connection,
            'isLoggedIn' => $isLoggedIn,
            'loggedUser' => $loggedUser,
            'loggedGroup' => $loggedGroup,
            'moderator' => $moderator,
            'noxen' => $noxen,
            'settings' => $settings,
            'users' => $users,
            'posts' => $posts,
            'groups' => $groups,
            'groups_users' => $groups_users,
            'footer' => $footer,
            'pages' => $pages);

        /* GET OPTIONAL SERVER DATA */
        if(isset($user_id)){
            $user = $connection->first('SELECT * FROM users WHERE id = ?', [$user_id]);
            $noxen_data = array_merge($noxen_data, array('user_id' => $user_id, 'user' => $user));
        }
        if(isset($post_id)){
            $post = $connection->first('SELECT * FROM posts WHERE id = ?', [$post_id]);
            $noxen_data = array_merge($noxen_data, array('post_id' => $post_id, 'post' => $post));
        }
        if(isset($group_id)){
            $group = $connection->first('SELECT * FROM groups WHERE id = ?', [$group_id]);
            $noxen_data = array_merge($noxen_data, array('group_id' => $group_id, 'group' => $group));
        }
        if(isset($page_id)){
            $page = $connection->first('SELECT * FROM pages WHERE id = ?', [$page_id]);
            $contents = $connection->all('SELECT * FROM content WHERE page_id = ?', [$page_id]);
            $noxen_data = array_merge($noxen_data, array('page_id' => $page_id, 'page' => $page, 'contents' => $contents));
        }
        if(isset($content_id)){
            $content = $connection->first('SELECT * FROM content WHERE id = ?', [$content_id]);
            $noxen_data = array_merge($noxen_data, array('content_id' => $content_id, 'content' => $content));
        }
?>