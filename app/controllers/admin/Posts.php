<?php

namespace app\controllers\admin;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Posts extends Index
{
    public function showForm(ViewFactory $view)
	{
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $users = $connection->all('SELECT * FROM users');
        
		return $view->create('admin/pages/check', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'users' => $users,
            'token' => $token,
        ));
	}

    public function showPost(ViewFactory $view, $id)
    {
        
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //POST SETTINGS
        $post = $connection->first('SELECT * FROM posts WHERE id = ?', [$id]);

        //CHECK IF USER EXISTS
        if(!$post){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }
        
        return $view->create('admin/post/info', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'post' => $post,
        ));
    }
    
    

        public function editForm(ViewFactory $view, $id)
    {
        
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER SETTINGS
        $post = $connection->first('SELECT * FROM posts WHERE id = ?', [$id]);

        //CHECK IF USER EXISTS
        if(!$post){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }

        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        return $view->create('admin/post/edit', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'post' => $post,
            'token' => $token,
        ));
    }

    public function editPost(ViewFactory $view, $id)
    {   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $post = $connection->first('SELECT * FROM posts WHERE id = ?', [$id]);
        
        $urlBuilder = $this->urlBuilder;
        

        //CHECK IF USER EXISTS
        if(!$post){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }

        //CHECK FIELDS
        $rules = 
        [
            'token' => ['required'],
            'title' => ['required'],
            'text' => ['required']
        ];
        $validator = $this->validator->create($this->request->post(), $rules);
        if($validator->isValid($errors))
        {
            //VALIDATE TOKEN [ANTI CSRF]
            $token = $_POST['token'];
            if($token == ""){
                return $view->create('admin/error/deny', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'session' => $this->session,
                    'token' => $token,
                ));
            }
            $session = $this->session;
            if($session->validateToken($token) == 1){

                $title = $_POST['title'];
                $text = $_POST['text'];

                $connection->query("UPDATE posts SET title = ? WHERE id = ?", [$title, $id]);
                $connection->query("UPDATE posts SET full_text = ? WHERE id = ?", [$text, $id]);

                $msg = "Post Updated";

                return $view->create('admin/pages/success', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
                'session' => $this->session,
                'token' => $token,
                'msg' => $msg,
            ));

            } else {
                return $view->create('admin/error/deny', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'session' => $this->session,
                    'token' => $token,
                ));
            }
            //--END VALIDATE TOKEN
        }
        else
        {
            return $view->create('admin/error/error', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
                'session' => $this->session,
                'errors' => $errors
            ));
            die();
        }
    }

    public function deletePost(ViewFactory $view, $id)
    {   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $post = $connection->first('SELECT * FROM posts WHERE id = ?', [$id]);
        
        $urlBuilder = $this->urlBuilder;
        

        //CHECK IF USER EXISTS
        if(!$post){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }

        //CHECK FIELDS
        $rules = 
        [
            'token' => ['required'],
        ];
        $validator = $this->validator->create($this->request->post(), $rules);
        if($validator->isValid($errors))
        {
            //VALIDATE TOKEN [ANTI CSRF]
            $token = $_POST['token'];
            if($token == ""){
                return $view->create('admin/error/deny', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'session' => $this->session,
                    'token' => $token,
                ));
            }
            $session = $this->session;
            if($session->validateToken($token) == 1){

                $connection->query("DELETE FROM posts WHERE id = ?", [$id]);

                $msg = "Post Deleted";

                return $view->create('admin/pages/success', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
                'session' => $this->session,
                'token' => $token,
                'msg' => $msg,
            ));

            } else {
                return $view->create('admin/error/deny', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'session' => $this->session,
                    'token' => $token,
                ));
            }
            //--END VALIDATE TOKEN
        }
        else
        {
            return $view->create('admin/error/error', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
                'user' => $user,
                'session' => $this->session,
                'errors' => $errors
            ));
            die();
        }
    }

}