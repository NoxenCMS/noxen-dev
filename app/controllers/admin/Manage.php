<?php

namespace app\controllers\admin;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Manage extends Index
{
	/**
	 * Welcome route.
	 * 
	 * @access  public
	 */

    
    public function showUsers(ViewFactory $view)
	{


        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $users = $connection->all('SELECT * FROM users');
        

		return $view->create('admin/manage/users/users', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'users' => $users,
            'token' => $token,
        ));
	}
    
    public function showUsersFilter(ViewFactory $view)
	{
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $filter_raw = $_POST['filter'];
        $filter = "%".$filter_raw."%";
        
        //VALIDATE TOKEN
        $token = $_POST['token'];
        
            if($token == ""){
                return $view->create('admin/error/deny', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'session' => $this->session,
                ));
            }
        $session = $this->session;
            if($session->validateToken($token) == 1){

                $users = $connection->all("SELECT * FROM users WHERE username LIKE ? OR email LIKE ?", [$filter, $filter]);
                
                //GENERATE TOKEN [ANTI CSRF]
                $session = $this->session;
                $token = $session->generateToken();

                return $view->create('admin/manage/users/users', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'users' => $users,
                    'filter_raw' => $filter_raw,
                    'filter' => $filter,
                    'token' => $token,
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
    
    public function showGroups(ViewFactory $view)
	{
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //GROUP LIST
        $groups = $connection->all('SELECT * FROM groups');
        
        
        $count = 0;
        
		return $view->create('admin/manage/groups/groups', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'groups' => $groups,
            'count' => $count,
            'connection' => $this->database->connection(),
        ));
	}

    public function showPosts(ViewFactory $view)
    {
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $posts = $connection->all('SELECT * FROM posts');
        
        return $view->create('admin/manage/posts/posts', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'posts' => $posts,
            'token' => $token,
        ));
    }

    public function showPostsFilter(ViewFactory $view)
    {
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //POST LIST
        $filter_raw = $_POST['filter'];
        $filter = "%".$filter_raw."%";
        
        //VALIDATE TOKEN
        $token = $_POST['token'];
        
            if($token == ""){
                return $view->create('admin/error/deny', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'session' => $this->session,
                ));
            }
        $session = $this->session;
            if($session->validateToken($token) == 1){

                $posts = $connection->all("SELECT * FROM posts WHERE title LIKE ? OR full_text LIKE ? or owner LIKE ?", [$filter, $filter, $filter]);
                
                //GENERATE TOKEN [ANTI CSRF]
                $session = $this->session;
                $token = $session->generateToken();

                return $view->create('admin/manage/posts/posts', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'posts' => $posts,
                    'filter_raw' => $filter_raw,
                    'filter' => $filter,
                    'token' => $token,
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
}