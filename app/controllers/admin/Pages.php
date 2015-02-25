<?php

namespace app\controllers\admin;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Pages extends Index
{
    public function showPages(ViewFactory $view)
	{
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $pages = $connection->all('SELECT * FROM pages');
        
		return $view->create('admin/pages/pages/pages', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'pages' => $pages,
            'token' => $token,
        ));
	}
    
    public function showPagesFilter(ViewFactory $view)
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

                $pages = $connection->all("SELECT * FROM pages WHERE name LIKE ?", [$filter]);
                
                //GENERATE TOKEN [ANTI CSRF]
                $session = $this->session;
                $token = $session->generateToken();

                return $view->create('admin/pages/pages/pages', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'pages' => $pages,
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
    
    public function showCreatePage(ViewFactory $view)
	{
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $pages = $connection->all('SELECT * FROM pages');
        
		return $view->create('admin/pages/pages/create/page', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'pages' => $pages,
            'token' => $token,
        ));
	}
    
    public function createPage(ViewFactory $view)
	{   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //PAGES LIST
        $pages = $connection->all('SELECT * FROM pages');
        
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
            
            //CHECK EXISTING PAGES
            $user_check = $connection->first('SELECT * FROM pages WHERE name = ?', [$name]);
            if($user_check != ""){
                
                $msg = "A page with the same name already exists";
                
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

                $connection->query('INSERT INTO pages (name) VALUES (?)', [$name]);

                $msg = "Page Created";

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
    
    public function showPage(ViewFactory $view, $id)
	{
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $page = $connection->first('SELECT * FROM pages WHERE id = ?', [$id]);
        
        $contents = $connection->all('SELECT * FROM content WHERE page_id = ?', [$id]);
        
        if(!$page){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }
        
		return $view->create('admin/pages/pages/info', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'page' => $page,
            'contents' => $contents,
            'token' => $token,
        ));
	}
    
    public function showCreateContent(ViewFactory $view, $id)
	{
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $pages = $connection->all('SELECT * FROM pages');
        $page = $connection->first('SELECT * FROM pages WHERE id = ?', [$id]);
        
        $contents = $connection->all('SELECT * FROM content');
        
		return $view->create('admin/pages/pages/create/content', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'pages' => $pages,
            'page' => $page,
            'contents' => $contents,
            'token' => $token,
        ));
	}
    
    public function createContent(ViewFactory $view, $id)
	{   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //PAGES LIST
        $pages = $connection->all('SELECT * FROM pages');
        
        $page = $connection->first('SELECT * FROM pages WHERE id = ?', [$id]);
        
        //CHECK FIELDS
        $rules = 
        [
            'name' => ['required', 'min_length:4', 'max_length:20'],
            'content' => ['required', 'min_length:4'],
            'token' => ['required'],
        ];
        $validator = $this->validator->create($this->request->post(), $rules);
        if($validator->isValid($errors))
        {
            $name = $_POST['name'];
            $content = $_POST['content'];
            
            //CHECK EXISTING PAGES
            $user_check = $connection->first('SELECT * FROM content WHERE name = ? and page_id = ?', [$name, $id]);
            if($user_check != ""){
                
                $msg = "A content with the same name already exists";
                
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

                $connection->query('INSERT INTO content (name, content, page_id) VALUES (?, ?, ?)', [$name, $content, $page->id]);

                $msg = "Content Created";

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
    
    public function showContent(ViewFactory $view, $id, $cid)
    {
        
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //POST SETTINGS
        $page = $connection->first('SELECT * FROM pages WHERE id = ?', [$id]);

        //CHECK IF USER EXISTS
        if(!$page){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }
        
        //POST SETTINGS
        $content = $connection->first('SELECT * FROM content WHERE id = ? AND page_id = ?', [$cid, $id]);

        //CHECK IF USER EXISTS
        if(!$content){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }
        
        return $view->create('admin/pages/pages/content/content', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'content' => $content,
            'page' => $page,
        ));
    }
    
    public function showEditContent(ViewFactory $view, $id, $cid)
    {
        
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //POST SETTINGS
        $page = $connection->first('SELECT * FROM pages WHERE id = ?', [$id]);

        //CHECK IF USER EXISTS
        if(!$page){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }
        
        //POST SETTINGS
        $content = $connection->first('SELECT * FROM content WHERE id = ? AND page_id = ?', [$cid, $id]);

        //CHECK IF USER EXISTS
        if(!$content){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }
        
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        return $view->create('admin/pages/pages/content/edit', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'content' => $content,
            'page' => $page,
            'token' => $token
        ));
    }
    
    public function editContent(ViewFactory $view, $id, $cid)
	{   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //PAGES LIST
        $pages = $connection->all('SELECT * FROM pages');
        
        $page = $connection->first('SELECT * FROM pages WHERE id = ?', [$id]);
        
        //CHECK FIELDS
        $rules = 
        [
            'name' => ['required', 'min_length:4', 'max_length:20'],
            'content' => ['required', 'min_length:4'],
            'token' => ['required'],
        ];
        $validator = $this->validator->create($this->request->post(), $rules);
        if($validator->isValid($errors))
        {
            $name = $_POST['name'];
            $content = $_POST['content'];
            
            
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

                $connection->query('UPDATE content SET name = ? WHERE id = ? AND page_id = ?', [$name, $cid, $id]);
                $connection->query('UPDATE content SET content = ? WHERE id = ? AND page_id = ?', [$content, $cid, $id]);

                $msg = "Content Updated";

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
    
    public function deleteContent(ViewFactory $view, $id, $cid)
    {
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $content = $connection->first('SELECT * FROM content WHERE id = ? AND page_id = ?', [$cid, $id]);
        
        $urlBuilder = $this->urlBuilder;
        

        //CHECK IF USER EXISTS
        if(!$content){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }


	   	//CHECK FIELDS
        $rules = 
        [
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

                $connection->query('DELETE FROM content WHERE id = ? and page_id = ?', [$cid, $id]);
                
                //SET MSG
                $msg = "Content Deleted";

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
                'user' => $user,
                'session' => $this->session,
                'errors' => $errors
            ));
            die();
        }
    }
}