<?php

namespace app\controllers\admin;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Index extends Controller
{
	/**
	 * Welcome route.
	 * 
	 * @access  public
*/  
	public function welcome(ViewFactory $view)
	{
		return $view->create('welcome');
	}
    
    public function home(ViewFactory $view)
	{
        $connection = $this->database->connection();
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        $string = file_get_contents("http://api.noxen.net/news");
        $json = json_decode($string);
        
        

        
		return $view->create('admin/home', array(
			'urlBuilder' => $this->urlBuilder,
			'settings' => $settings,
            'json' => $json
		));
	}
}