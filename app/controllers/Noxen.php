<?php

namespace app\controllers;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;
use \mako\database\connectionManager;

class Noxen extends Index
{

    
    public function content($content, $page_id, $connection)
    {
        if(isset($content)){
            $content_text = $connection->first('SELECT * FROM content WHERE id = ?', [$content]);
            if($content_text != ""){
            	echo $content_text->content;
            } else {
            	$content_text = $connection->first('SELECT * FROM content WHERE name = ? and page_id = ?', [$content, $page_id]);
            	echo $content_text->content;
            }
        }
    }
}