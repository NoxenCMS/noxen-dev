<?php

use mako\auth\gatekeeper;
use \mako\view\ViewFactory;
use \mako\http\routing\URLBuilder;
use \mako\database\connectionManager;


$filters->register('UserProtected', function(gatekeeper $gatekeeper, ViewFactory $view, URLBuilder $urlBuilder, ConnectionManager $connection)
{
	$isLoggedIn = $gatekeeper->isLoggedIn();

	if($isLoggedIn != 1){

		$url = $urlBuilder->to('/');
		header("Location: $url");
		die();
	}
    
});

$filters->register('AdminProtected', function(gatekeeper $gatekeeper, ViewFactory $view, URLBuilder $urlBuilder, ConnectionManager $connection)
{
	$isLoggedIn = $gatekeeper->isLoggedIn();

	if($isLoggedIn != 1){

		$login = $urlBuilder->to('/admin/login');
		header("Location: $login");
		die();
	}

    
	$settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);

	$user = $gatekeeper->getUser();

	$id = $user->id;

	$group_con = $connection->first("SELECT * FROM groups_users WHERE user_id = ?", [$id]);

	$group_id = $group_con->group_id;

	$group = $connection->first("SELECT * FROM groups WHERE id = ?", [$group_id]);

	$moderator = $group->moderator;

	if($moderator != 1){
        
        $url = $urlBuilder->to('admin/logout');

		$msg = "You're not a moderator";

		return $view->create('admin/error/custom', array(
	        'urlBuilder' => $urlBuilder,
	        'settings' => $settings,
	        'msg' => $msg,
	        'disabled' => true,
	    ));
	}
});