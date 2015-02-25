<?php

namespace app\controllers\admin;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Check extends Index
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
}