<?php

namespace app\controllers;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Index extends Controller
{   
    public function demo(ViewFactory $view)
	{
        /* --- NOXEN ACTIVATION CODES --- */

        /* GENERAL VARIABLES [urlBuilder + connection] */
        $urlBuilder = $this->urlBuilder;
        $connection = $this->database->connection();

        /* OPTIONS - OPTIONAL */
        /* IMPORTANT: $page_id is required if you're using page content */
        /* Adding an id to any of this variables allows you to get the information for the specific user / post / page / group / content as an object */
        $page_id = "1"; // = OBJECT: $page AND OBJECT: $contents
        $user_id = ""; // = OBJECT: $user
        $post_id = ""; // = OBJECT: $post
        $group_id = ""; // = OBJECT: $group
        $content_id = ""; // = OBJECT: $content

        /* START NOXEN */
        $noxen = new Noxen();
        include 'NoxenGetData.php';
        
        /* ---------------------------------------- */
        /* --- NOXEN IS NOW WORKING, THE VARIABLES YOU CAN USE ARE THE FOLLOWING ONES: --- */
        /* ---------------------------------------- */
        /* ------ $settings - Website Settigns ------ */
        /* ------ $users - Full Users List ------ */
        /* ------ $posts - Full Posts List ------ */
        /* ------ $groups - Full Groups List ------ */
        /* ------ $groups_users - Relation between suers and groups ------ */
        /* ------ $footer - Footer Settings ------ */
        /* ------ $pages - Full Pages List ------ */
        /* ------ $isLoggedIn - Returns 1 or 0 if the user is logged in or not ------ */
        /* ------ $loggedUser - Logged In user information ------ */
        /* ------ $loggedGroup - Logged In user's group information ------ */
        /* ------ $moderator - Returns 1 or 0 if the logged in user is a moderator or not ------ */
        /* ---------------------------------------- */
        /* ------ OPTIONAL DATA VARIABLES [ONLY WORKING IF THE OPTIONAL VARIABLES ARE SET] ------ */
        /* ---------------------------------------- */
        /* ------ $user - Selected User Info ------ */
        /* ------ $user_id - Selected User ID ------ */
        /* ------ $post - Selected Post Info ------ */
        /* ------ $post_id - Selected Post ID ------ */
        /* ------ $group - Selected Group Info ------ */
        /* ------ $group_id - Selected Group ID ------ */
        /* ------ $page - Selected Page Info ------ */
        /* ------ $page_id - Selected Page ID ------ */
        /* ------ $content - Selected Content Info ------ */
        /* ------ $content_id - Selected Content ID ------ */
        /* ------ $contents - Selected Page Contents ------ */
        
        
        /* IMPORTANT */
        
        /* TO ADD MORE DATA TO THE VIEW ARRAY, PLSE USE THE FOLLOWING EXAMPLE: */
        /* $test = "Test variable to push to the view";
        /* $noxen_data = array_merge($noxen_data, array("test" => $test)); */
        
        /* --- START CODING <3 --- */
        
        
        
        
        
        
        
        
   
        /* CREATE THE VIEW (return the php / html document + variables) */
		/* TO SHOW PAGE CONTENT SET IN THE ADMIN PANEL IN THE HTML DOCUMENT GENERATED BY THE VIEW USE THE FOLLOWING EXAMPLE: (INCLUDED IN THE DEMO)*/
		/* <?php $content = 'CONTENT_NAME_OR_ID'; $noxen->content($content, $page_id, $connection) ?> */
		/* If you set the content name, you will need to specify the page_id optional paramenter at the top of this page */
		
        return $view->create('website/index', $noxen_data);
	}
    
    
	public function welcome(ViewFactory $view)
	{
		return $view->create('welcome');
	}
}