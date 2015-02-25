<?php

namespace app\controllers;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Demo extends Controller
{
	/**
	 * Welcome route.
	 * 
	 * @access  public
*/  
    
    public function logout(ViewFactory $view)
	{
        $noxen = new Noxen();
        include 'NoxenGetData.php';
        
        $this->gatekeeper->logout();
        
        $url = $urlBuilder->to('/demo');
        header("Location: $url");
        die();
	}
    
    public function showRegister(ViewFactory $view)
	{
        $page_id = "1";
        $noxen = new Noxen();
        include 'NoxenGetData.php';
        
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        $noxen_data = array_merge($noxen_data, array("session" => $session, 'token' => $token));
        
        return $view->create('website/register', $noxen_data);
	}
    
    public function showLogin(ViewFactory $view)
	{
        $page_id = "1";
        $noxen = new Noxen();
        include 'NoxenGetData.php';
        
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        $noxen_data = array_merge($noxen_data, array("session" => $session, 'token' => $token));
        
        return $view->create('website/login', $noxen_data);
	}
    
    public function news(ViewFactory $view)
	{
        $noxen = new Noxen();
        include 'NoxenGetData.php';
        return $view->create('website/news', $noxen_data);
	}
    
    public function showAccount(ViewFactory $view)
	{
        $page_id = "1";
        $noxen = new Noxen();
        include 'NoxenGetData.php';
        
        return $view->create('website/account', $noxen_data);
	}
    
    public function login(ViewFactory $view)
	{
        $page_id = "1";
        $noxen = new Noxen();
        include 'NoxenGetData.php';
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        //CHECK FIELDS
        $rules = 
        [
            'token' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ];
        $validator = $this->validator->create($this->request->post(), $rules);
        if($validator->isValid($errors))
        {
            //VALIDATE TOKEN [ANTI CSRF]
            $token = $_POST['token'];
            if($token == ""){
                return $view->create('website/deny', $noxen_data);
            }
            $session = $this->session;
            if($session->validateToken($token) == 1){

                
                $email = $_POST['email'];
                $password = $_POST['password'];


                $successful = $this->gatekeeper->login($email, $password);

                if($successful == 1){

                    $user = $connection->first('SELECT * FROM users WHERE email = ?', [$email]);
                    $msg = "Welcome back " . $user->username;
                    $url = $urlBuilder->to('/demo/account');
                    $noxen_data = array_merge($noxen_data, array("session" => $this->session, 'token' => $token, 'msg' => $msg, 'url' => $url, 'disabled' => true));

                    return $view->create('website/post', $noxen_data);
                    
                } elseif($successful == 100) {
                    $msg = "This account is banned";

                    $noxen_data = array_merge($noxen_data, array("session" => $this->session, 'token' => $token, 'msg' => $msg));

                    return $view->create('website/custom_error', $noxen_data);
                    
                } elseif($successful == 101) {
                    $msg = "You need to acivate your account first";

                    $noxen_data = array_merge($noxen_data, array("session" => $this->session, 'token' => $token, 'msg' => $msg));

                    return $view->create('website/custom_error', $noxen_data);
                    
                } elseif($successful == 102) {
                    $msg = "Wrong email or password";
                    
                    $noxen_data = array_merge($noxen_data, array("session" => $this->session, 'token' => $token, 'msg' => $msg));

                    return $view->create('website/custom_error', $noxen_data);
                }
            } else {
                return $view->create('website/deny', $noxen_data);
            }
            //--END VALIDATE TOKEN
        }
        else
        {
            $noxen_data = array_merge($noxen_data, array('errors' => $errors));
            return $view->create('website/error', $noxen_data);
        }
	}
    
    public function register(ViewFactory $view)
	{
        $page_id = "1";
        $noxen = new Noxen();
        include 'NoxenGetData.php';
        
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];

        //CHECK FIELDS
        $rules = 
        [
            'token' => ['required'],
            'email' => ['required'],
            'username' => ['required'],
            'password' => ['required'],
            'repeat_password' => ['required', 'match:"password"'],
        ];
        $validator = $this->validator->create($this->request->post(), $rules);
        if($validator->isValid($errors))
        {
            //VALIDATE TOKEN [ANTI CSRF]
            $token = $_POST['token'];
            if($token == ""){
                return $view->create('website/deny', $noxen_data);
            }
            $session = $this->session;
            if($session->validateToken($token) == 1){
                
                $check = $connection->first('SELECT * FROM users WHERE email = ?', [$email]);
                $check2 = $connection->first('SELECT * FROM users WHERE username = ?', [$username]);
                
                if($check != ""){
                    $msg = "A user with that email already exists";
                    
                    $noxen_data = array_merge($noxen_data, array('msg' => $msg));

                    return $view->create('website/custom_error', $noxen_data);
                } elseif($check2 != ""){
                    $msg = "A user with that username already exists";
                    
                    $noxen_data = array_merge($noxen_data, array('msg' => $msg));

                    return $view->create('website/custom_error', $noxen_data);
                }
                
                $user = $this->gatekeeper->createUser($email, $username, $password, true);

                $user = $connection->first('SELECT * FROM users WHERE email = ?', [$email]);
                $msg = "Registered as " . $user->username;
                $url = $urlBuilder->to('/demo/login');
                $groupProvider = $this->gatekeeper->getGroupProvider();
                $userProvider = $this->gatekeeper->getUserProvider();
                $defaultGroupId = $settings->default_user_group;
                $group = $groupProvider->getById($defaultGroupId);
                $user = $userProvider->getByEmail($email);
                $group->addUser($user);
                
                $noxen_data = array_merge($noxen_data, array("session" => $this->session, 'token' => $token, 'msg' => $msg, 'url' => $url, 'disabled' => true));
                
                
                
                return $view->create('website/post', $noxen_data);

                
            } else {
                return $view->create('website/deny', $noxen_data);
            }
            //--END VALIDATE TOKEN
        }
        else
        {
            $noxen_data = array_merge($noxen_data, array('errors' => $errors));
            return $view->create('website/error', $noxen_data);
        }
	}

}