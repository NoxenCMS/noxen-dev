<?php


/* ------------------------------------------------------------------------------ */

/* -------------------------------- NOXEN ROUTES -------------------------------- */

/* ------------------------------------------------------------------------------ */




$routes->group(['namespace' => 'app\controllers'], function($routes)
{
    
	/* MAIN WEBSITE ROUTES - YOU MUST CHANGE THIS ROUTES AND MATCH THEM WITH YOUR SITE PAGES */
    /* ROUTES FOLLOW THIS ORDER: $routes->HTTPMETHOD('PATH', 'CONTROLLER::FUNCTION'); */
    /* EXAMPLE: $routes->get('/', 'Index::welcome'); */
    
	$routes->get('/', 'Index::welcome');
    
    ///*INSTALL
    $routes->get('/install', 'Install::installer');
    $routes->post('/install', 'Install::install');
    $routes->get('/install/done', 'Install::done');
    //*/ENDINSTALL
    
    /* THE FOLLOWING ROUTES ARE AN EXAMPLE OF THE DEMO WEBSITE */
    
    $routes->get('/test', 'Index::test');
    $routes->get('/demo', 'Index::demo');
    $routes->get('/demo/login', 'Demo::showLogin');
    $routes->post('/demo/login', 'Demo::login');
    $routes->get('/demo/register', 'Demo::showRegister');
    $routes->post('/demo/register', 'Demo::register');
    
});

$routes->group(['namespace' => 'app\controllers', 'before' => 'UserProtected'], function($routes)
{
    
	/* PROTECTED WEBSITE ROUTES - YOU MUST CHANGE THIS ROUTES AND MATCH THEM WITH YOUR SITE PAGES */
    /* PROTECTED WEBSITE ROUTES REQUIRE THE USER TO BE LOGGED IN IN ORDER TO VIEW THEM */
    
	$routes->get('/demo/protected', 'Index::showProtected');
    $routes->get('/demo/account', 'Demo::showAccount');
    $routes->get('/demo/news', 'Demo::news');
    $routes->get('/demo/logout', 'Demo::logout');

    
});



















































/* ------------------------------------------------------------------------------ */

/* NOXEN ROUTES - DO NOT TOUCH THE ROUTES BELOW UNLESS YOU KNOW WHAT YOU'RE DOING */

/* ------------------------------------------------------------------------------ */

$routes->group(['namespace' => 'app\controllers\admin'], function($routes)
{
	//LOGIN ADMIN ONLY
	$routes->get('/admin/login', 'Users::LoginForm');
	$routes->post('/admin/login', 'Users::Login');
    $routes->get('/admin/logout', 'Users::Logout');
});


$routes->group(['namespace' => 'app\controllers\admin', 'before' => 'AdminProtected'], function($routes)
{

    //PROTECTED NOXEN ROUTES

    //MAIN ROUTES
    $routes->get('/admin', 'Index::home');

    //CREATE ROUTES
    $routes->get('/admin/create/user', 'Create::showForm');
    $routes->post('/admin/create/user', 'Create::createUser');
    $routes->get('/admin/create/group', 'Create::showGroupsForm');
    $routes->post('/admin/create/group', 'Create::createGroup');
    $routes->get('/admin/create/post', 'Create::showPostsForm');
    $routes->post('/admin/create/post', 'Create::createPost');
    
    //MANAGE ROUTES
    $routes->get('/admin/manage/users', 'Manage::showUsers');
    $routes->post('/admin/manage/users', 'Manage::showUsersFilter');
    $routes->get('/admin/manage/users/settings', 'Settings::userSettings');
    $routes->post('/admin/manage/users/settings', 'Settings::updateUserSettings');
    $routes->get('/admin/manage/groups', 'Manage::showGroups');
    $routes->get('/admin/manage/posts', 'Manage::showPosts');
    $routes->post('/admin/manage/posts', 'Manage::showPostsFilter');
    
    //USER ROUTES
    $routes->get('/admin/users', 'Users::showUsers');
    $routes->get('/admin/user/{id}', 'Users::showUser', 'profile')->when(['id' => '[0-9]+']);
    $routes->get('/admin/user/{id}/edit', 'Users::editForm')->when(['id' => '[0-9]+']);
    $routes->post('/admin/user/{id}/edit', 'Users::editUser')->when(['id' => '[0-9]+']);
    $routes->get('/admin/user/{id}/delete', 'Check::showForm')->when(['id' => '[0-9]+']);
    $routes->post('/admin/user/{id}/delete', 'Users::deleteUser')->when(['id' => '[0-9]+']);
    $routes->get('/admin/user/{id}/activate', 'Check::showForm')->when(['id' => '[0-9]+']);
    $routes->get('/admin/user/{id}/deactivate', 'Check::showForm')->when(['id' => '[0-9]+']);
    $routes->get('/admin/user/{id}/ban', 'Check::showForm')->when(['id' => '[0-9]+']);
    $routes->get('/admin/user/{id}/unban', 'Check::showForm')->when(['id' => '[0-9]+']);
    $routes->post('/admin/user/{id}/activate', 'Users::activateUser')->when(['id' => '[0-9]+']);
    $routes->post('/admin/user/{id}/deactivate', 'Users::deactivateUser')->when(['id' => '[0-9]+']);
    $routes->post('/admin/user/{id}/ban', 'Users::banUser')->when(['id' => '[0-9]+']);
    $routes->post('/admin/user/{id}/unban', 'Users::unbanUser')->when(['id' => '[0-9]+']);
    $routes->get('/admin/user/{id}/group', 'Users::groupUser')->when(['id' => '[0-9]+']);
    $routes->post('/admin/user/{id}/group', 'Users::changeGroupUser')->when(['id' => '[0-9]+']);
    $routes->get('/admin/user/{id}/resend', 'Check::showForm')->when(['id' => '[0-9]+']);
    $routes->post('/admin/user/{id}/resend', 'Users::resendCode')->when(['id' => '[0-9]+']);
    
    //GROUP ROUTES
    $routes->get('/admin/group/{id}', 'Groups::showGroup')->when(['id' => '[0-9]+']);
    $routes->get('/admin/group/{id}/delete', 'Check::showForm')->when(['id' => '[0-9]+']);
    $routes->post('/admin/group/{id}/delete', 'Groups::deleteGroup')->when(['id' => '[0-9]+']);
    $routes->get('/admin/group/{id}/members', 'Groups::showMembers')->when(['id' => '[0-9]+']);

    //POST ROUTES
    $routes->get('/admin/post/{id}', 'Posts::showPost')->when(['id' => '[0-9]+']);
    $routes->get('/admin/post/{id}/edit', 'Posts::editForm')->when(['id' => '[0-9]+']);
    $routes->post('/admin/post/{id}/edit', 'Posts::editPost')->when(['id' => '[0-9]+']);
    $routes->get('/admin/post/{id}/delete', 'Check::showForm')->when(['id' => '[0-9]+']);
    $routes->post('/admin/post/{id}/delete', 'Posts::deletePost')->when(['id' => '[0-9]+']);

    //WEBSITE ROUTES
    $routes->get('/admin/website/settings', 'Website::showSettings');
    $routes->get('/admin/website/settings/edit', 'Website::settingsForm');
    $routes->post('/admin/website/settings/edit', 'Website::updateSettings');
    $routes->get('/admin/website/footer', 'Website::showFooter');
    $routes->get('/admin/website/footer/edit', 'Website::footerForm');
    $routes->post('/admin/website/footer/edit', 'Website::updateFooter');
    
    //PAGES
    $routes->get('/admin/pages', 'Pages::showPages');
    $routes->post('/admin/pages', 'Pages::showPagesFilter');
    $routes->get('/admin/pages/create', 'Pages::showCreatePage');
    $routes->post('/admin/pages/create', 'Pages::CreatePage');
    $routes->get('/admin/pages/{id}', 'Pages::showPage')->when(['id' => '[0-9]+']);
    $routes->get('/admin/pages/{id}/create', 'Pages::showCreateContent')->when(['id' => '[0-9]+']);
    $routes->post('/admin/pages/{id}/create', 'Pages::CreateContent')->when(['id' => '[0-9]+']);
    $routes->get('/admin/pages/{id}/{cid}', 'Pages::showContent')->when(['id' => '[0-9]+', 'cid' => '[0-9]+']);
    $routes->get('/admin/pages/{id}/{cid}/edit', 'Pages::showEditContent')->when(['id' => '[0-9]+', 'cid' => '[0-9]+']);
    $routes->post('/admin/pages/{id}/{cid}/edit', 'Pages::editContent')->when(['id' => '[0-9]+', 'cid' => '[0-9]+']);
    $routes->get('/admin/pages/{id}/{cid}/delete', 'Check::showForm')->when(['id' => '[0-9]+', 'cid' => '[0-9]+']);
    $routes->post('/admin/pages/{id}/{cid}/delete', 'Pages::deleteContent')->when(['id' => '[0-9]+', 'cid' => '[0-9]+']);
});