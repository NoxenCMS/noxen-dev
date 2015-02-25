<?php

namespace app\controllers\admin;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Create extends Index
{
	/**
	 * Welcome route.
	 * 
	 * @access  public
	 */

    
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
        
        
        
		return $view->create('admin/create/user', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'users' => $users,
            'session' => $this->session,
            'token' => $token,
        ));
	}
    
    public function showGroupsForm(ViewFactory $view)
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
        
        
        
		return $view->create('admin/create/group', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'users' => $users,
            'session' => $this->session,
            'token' => $token,
        ));
	}

    public function showPostsForm(ViewFactory $view)
    {
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        return $view->create('admin/create/post', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'session' => $this->session,
            'token' => $token,
        ));
    }
    
    public function createUser(ViewFactory $view)
	{   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $users = $connection->all('SELECT * FROM users');
        
        //CHECK FIELDS
        $rules = 
        [
            'username' => ['required', 'min_length:4', 'max_length:20'],
            'password' => ['required'],
            'repeat_password' => ['required', 'match:"password"'],
            'token' => ['required'],
            'email'    => ['required', 'email'],
        ];
        $validator = $this->validator->create($this->request->post(), $rules);
        if($validator->isValid($errors))
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            
            //CHECK EXISTING USERS
            $user_check = $connection->first('SELECT * FROM users WHERE username = ? or email = ?', [$username, $email]);
            if($user_check != ""){
                $msg = "An account with the same username or email already exists";
                return $view->create('admin/error/custom', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'session' => $this->session,
                    'msg' => $msg,
                ));
            }
            
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

                $user = $this->gatekeeper->createUser($email, $username, $password);
                $userProvider = $this->gatekeeper->getUserProvider();
                $user = $userProvider->getByEmail($email);
                $groupProvider = $this->gatekeeper->getGroupProvider();
                $default_user_group = $settings->default_user_group;
                $group = $groupProvider->getById($default_user_group);
                $group->addUser($user);
                $group->save();

                $msg = "Account Created";

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
                'users' => $users,
                'session' => $this->session,
                'errors' => $errors
            ));
            die();
        }
	}
    
        public function createGroup(ViewFactory $view)
	{   
           
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $users = $connection->all('SELECT * FROM users');
        
        //CHECK FIELDS
        $rules = 
        [
            'name' => ['required', 'min_length:4', 'max_length:20'],
            'token' => ['required'],
        ];
        $validator = $this->validator->create($this->request->post(), $rules);
        if($validator->isValid($errors))
        {
            $name = $_POST['name'];
            if(isset($_POST['moderator'])){
                $moderator = $_POST['moderator'];
            }
            
            //CHECK EXISTING USERS
            $group_check = $connection->first('SELECT * FROM groups WHERE name = ?', [$name]);
            if($group_check != ""){ 
                $msg = "A group with the same name already exists";
                return $view->create('admin/error/custom', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'session' => $this->session,
                    'msg' => $msg,
                ));
            }
            
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

                $group = $this->gatekeeper->createGroup($name);
                
                if(isset($moderator)){
                    if($moderator == 'on'){
                        $connection->query('UPDATE groups SET moderator = 1 WHERE name = ?', [$name]);
                    }
                }
                
                $msg = "Group Created";

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
                'users' => $users,
                'session' => $this->session,
                'errors' => $errors
            ));
            die();
        }
	}

    public function createPost(ViewFactory $view)
    {   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $users = $connection->all('SELECT * FROM users');
        
        //CHECK FIELDS
        $rules = 
        [
            'title' => ['required', 'min_length:5', 'max_length:50'],
            'text' => ['required', 'min_length:5'],
            'token' => ['required'],
        ];
        $validator = $this->validator->create($this->request->post(), $rules);
        if($validator->isValid($errors))
        {
            $title = $_POST['title'];
            $text = $_POST['text'];
            
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

                $post_owner = $this->gatekeeper->getUser();

                $owner = $post_owner->username;
                $connection->query("INSERT INTO posts (title, full_text, owner) values (?, ?, ?)", [$title, $text ,$owner]);

                $msg = "Post Created";

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
                'users' => $users,
                'session' => $this->session,
                'errors' => $errors
            ));
            die();
        }
    }
}