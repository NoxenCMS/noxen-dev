<?php

namespace app\controllers\admin;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Website extends Index
{
    
    public function showFooter(ViewFactory $view)
	{
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        $footer = $connection->first('SELECT * FROM footer WHERE `id` = ?', ['1']);
        
		return $view->create('admin/website/footer/footer', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'footer' => $footer,
            'token' => $token,
        ));
	}
    
    public function footerForm(ViewFactory $view)
	{
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        $footer = $connection->first('SELECT * FROM footer WHERE `id` = ?', ['1']);
        
		return $view->create('admin/website/footer/edit', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'footer' => $footer,
            'token' => $token,
        ));
	}
    
        public function updateFooter(ViewFactory $view)
    {   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        $footer = $connection->first('SELECT * FROM footer WHERE `id` = ?', ['1']);

        $urlBuilder = $this->urlBuilder;

	   	//CHECK FIELDS
        $rules = 
        [
            'token' => ['required'],
            'title' => ['required'],
            'bio' => ['required']
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
                $bio = $_POST['bio'];
                
                $connection->query('UPDATE footer SET title = ? WHERE id = ?', [$title, 1]);
                $connection->query('UPDATE footer SET bio = ? WHERE id = ?', [$bio, 1]);
                
                $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
                $footer = $connection->first('SELECT * FROM footer WHERE `id` = ?', ['1']);

                $msg = "Settings Updated";

                return $view->create('admin/pages/success', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
                'session' => $this->session,
                'token' => $token,
                'footer' => $footer,
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
    
	public function showSettings(ViewFactory $view)
	{
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
		return $view->create('admin/website/settings/settings', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'token' => $token,
        ));
	}

    public function settingsForm(ViewFactory $view)
	{
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
		return $view->create('admin/website/settings/edit', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'token' => $token,
        ));
	}
    
    public function updateSettings(ViewFactory $view)
    {   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);

        $urlBuilder = $this->urlBuilder;

	   	//CHECK FIELDS
        $rules = 
        [
            'token' => ['required'],
            'app_name' => ['required'],
            'app_version' => ['required'],
            'app_author' => ['required'],
            'maintenance' => ['required']
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

                $app_name = $_POST['app_name'];
                $app_author = $_POST['app_author'];
                $app_version = $_POST['app_version'];
                $maintenance = $_POST['maintenance'];
                
                $connection->query('UPDATE settings SET app_name = ? WHERE id = ?', [$app_name, 1]);
                $connection->query('UPDATE settings SET app_author = ? WHERE id = ?', [$app_author, 1]);
                $connection->query('UPDATE settings SET app_version = ? WHERE id = ?', [$app_version, 1]);
                $connection->query('UPDATE settings SET maintenance = ? WHERE id = ?', [$maintenance, 1]);
                
                $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);

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