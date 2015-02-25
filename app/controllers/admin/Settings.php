<?php

namespace app\controllers\admin;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Settings extends Index
{
	/**
	 * Welcome route.
	 * 
	 * @access  public
	 */

    
    public function userSettings(ViewFactory $view)
	{
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();

        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $users = $connection->all('SELECT * FROM users');
        
        //GROUP LIST
        $groups = $connection->all('SELECT * FROM groups');

		return $view->create('admin/manage/users/settings', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'users' => $users,
            'groups' => $groups,
            'token' => $token,
        ));
	}

    public function updateUserSettings(ViewFactory $view)
    {
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $users = $connection->all('SELECT * FROM users');
        
        $urlBuilder = $this->urlBuilder;
        
        //CHECK FIELDS
        $rules = 
        [   
            'select' => ['required'],
            'token' => ['required']
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

                $group_id = $_POST['select'];

                $connection->query('UPDATE settings SET default_user_group = ?', [$group_id]);

                //SET MSG
                $msg = "Settings Updated";

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
}