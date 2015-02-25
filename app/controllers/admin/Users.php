<?php

namespace app\controllers\admin;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory; 

class Users extends Index
{
	/**
	 * Welcome route.
	 * 
	 * @access  public
	 */



    public function logout(ViewFactory $view)
    {
        $this->gatekeeper->logout();

        $login = $this->urlBuilder->to('/admin/login');
        header("Location: $login");
        die();
    }

    public function loginForm(ViewFactory $view)
    {

        $user = $this->gatekeeper->getUser();

        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();

        return $view->create('admin/login/login', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'token' => $token,
        ));
    }

    public function login(ViewFactory $view)
    {   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);

        
        $urlBuilder = $this->urlBuilder;
        
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
                return $view->create('admin/error/deny', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'session' => $this->session,
                    'token' => $token,
                    'disabled' => true,
                ));
            }
            $session = $this->session;
            if($session->validateToken($token) == 1){

                
                $email = $_POST['email'];
                $password = $_POST['password'];


                $successful = $this->gatekeeper->login($email, $password);

                if($successful == 1){

                    $msg = "Logged In...";

                    return $view->create('admin/login/post', array(
                        'urlBuilder' => $this->urlBuilder,
                        'settings' => $settings,
                        'session' => $this->session,
                        'token' => $token,
                        'msg' => $msg,
                    ));
                    
                } elseif($successful == 100) {
                    $msg = "This account is banned";

                    return $view->create('admin/error/custom', array(
                        'urlBuilder' => $this->urlBuilder,
                        'settings' => $settings,
                        'session' => $this->session,
                        'token' => $token,
                        'msg' => $msg,
                        'disabled' => true,
                    ));
                    
                } elseif($successful == 101) {
                    $msg = "You need to acivate your account first";

                    return $view->create('admin/error/custom', array(
                        'urlBuilder' => $this->urlBuilder,
                        'settings' => $settings,
                        'session' => $this->session,
                        'token' => $token,
                        'msg' => $msg,
                        'disabled' => true,
                    ));
                    
                } elseif($successful == 102) {
                    $msg = "Wrong email or password";

                    return $view->create('admin/error/custom', array(
                        'urlBuilder' => $this->urlBuilder,
                        'settings' => $settings,
                        'session' => $this->session,
                        'token' => $token,
                        'msg' => $msg,
                        'disabled' => true,
                    ));
                }
            } else {
                return $view->create('admin/error/deny', array(
                    'urlBuilder' => $this->urlBuilder,
                    'settings' => $settings,
                    'session' => $this->session,
                    'token' => $token,
                    'disabled' => true,
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
                'errors' => $errors,
                'disabled' => true,
            ));
            die();
        }
    }

    public function editForm(ViewFactory $view, $id)
    {
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER SETTINGS
        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$id]);

        //CHECK IF USER EXISTS
        if(!$user){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }
        
        $connector = $connection->first('SELECT * FROM groups_users WHERE user_id = ?', [$id]);
        $group_id = $connector->group_id;
        $group = $connection->first('SELECT * FROM groups WHERE id = ?', [$group_id]);
        
        
        return $view->create('admin/user/edit', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'user' => $user,
            'group' => $group,
            'token' => $token,
        ));
    }
    
    public function editUser(ViewFactory $view, $id)
    {   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$id]);
        
        $urlBuilder = $this->urlBuilder;
        

        //CHECK IF USER EXISTS
        if(!$user){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }

	   	//CHECK FIELDS
        $rules = 
        [
            'token' => ['required'],
            'email' => ['required']
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

                $email = $_POST['email'];
                //UPDATE USER
                $exists = $connection->first('SELECT * FROM users WHERE email = ? AND id != ?', [$email, $id]);
                
                if($exists != ""){
                    $msg = "An account with this email already exists";
                    return $view->create('admin/error/custom', array(
                        'urlBuilder' => $this->urlBuilder,
                        'settings' => $settings,
                        'msg' => $msg
                    ));
                    die();
                }

                $msg = "Account Updated";

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
    
    public function showUser(ViewFactory $view, $id)
	{
        
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER SETTINGS
        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$id]);

        //CHECK IF USER EXISTS
        if(!$user){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }
        
        $connector = $connection->first('SELECT * FROM groups_users WHERE user_id = ?', [$id]);
        if($connector != ""){
            $nogroup = 1;
            $group_id = $connector->group_id;
            $group = $connection->first('SELECT * FROM groups WHERE id = ?', [$group_id]);
        } else {
            $nogroup = 0;
            $group = 0;
        }
        
        
		return $view->create('admin/user/profile', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'user' => $user,
            'nogroup' => $nogroup,
            'group' => $group
        ));
	}
    
    public function activateUser(ViewFactory $view, $id)
    {   
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$id]);
        
        $urlBuilder = $this->urlBuilder;
        

        //CHECK IF USER EXISTS
        if(!$user){
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

                //UPDATE USER
                $user_token = $user->action_token;
                $userProvider = $this->gatekeeper->getUserProvider();
                $user_action = $userProvider->getByActionToken($user_token);
                $user_action->activate();
                $user_action->save();

                $msg = "Account Activated";

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
    
    public function deactivateUser(ViewFactory $view, $id)
    {
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$id]);
        
        $urlBuilder = $this->urlBuilder;
        

        //CHECK IF USER EXISTS
        if(!$user){
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

                //UPDATE USER
                $user_token = $user->action_token;
                $userProvider = $this->gatekeeper->getUserProvider();
                $user_action = $userProvider->getByActionToken($user_token);
                $user_action->deactivate();
                $user_action->save();

                $msg = "Account Deactivated";

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
    
    public function banUser(ViewFactory $view, $id)
    {
                //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$id]);
        
        $urlBuilder = $this->urlBuilder;
        

        //CHECK IF USER EXISTS
        if(!$user){
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

                //UPDATE USER
                $user_token = $user->action_token;
                $userProvider = $this->gatekeeper->getUserProvider();
                $user_action = $userProvider->getByActionToken($user_token);
                $user_action->ban();
                $user_action->save();

                $msg = "Account Banned";

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
    
    public function unbanUser(ViewFactory $view, $id)
    {
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$id]);
        
        $urlBuilder = $this->urlBuilder;
        

        //CHECK IF USER EXISTS
        if(!$user){
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

                //UPDATE USER
                $user_token = $user->action_token;
                $userProvider = $this->gatekeeper->getUserProvider();
                $user_action = $userProvider->getByActionToken($user_token);
                $user_action->unban();
                $user_action->save();

                $msg = "Account Activated";

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
    
    public function groupUser(ViewFactory $view, $id)
    {
        //GENERATE TOKEN [ANTI CSRF]
        $session = $this->session;
        $token = $session->generateToken();
        
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$id]);
        
        $groups = $connection->all('SELECT * FROM groups');
        
        $urlBuilder = $this->urlBuilder;
        
        //CHECK IF USER EXISTS
        if(!$user){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }

        return $view->create('admin/user/group', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'user' => $user,
            'token' => $token,
            'groups' => $groups,
        ));
    }
    
    public function changeGroupUser(ViewFactory $view, $id)
    {
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$id]);
        
        $urlBuilder = $this->urlBuilder;
        

        //CHECK IF USER EXISTS
        if(!$user){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }

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

                //UPDATE GROUP                
                $userProvider = $this->gatekeeper->getUserProvider();
                $user = $userProvider->getById($id);
                $user_check = $connection->first('SELECT * FROM groups_users WHERE user_id = ?', [$id]);
                $current_group = $user_check->group_id;
                $groupProvider = $this->gatekeeper->getGroupProvider();
                
                $group = $groupProvider->getById($current_group);
                $group->removeUser($user);
                $group->save();
                
                $group_id = $_POST['select'];
                $group = $groupProvider->getById($group_id);
                $group->addUser($user);
                $group->save();
                
                //SET MSG
                $msg = "Account Updated";

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
    
    public function deleteUser(ViewFactory $view, $id)
    {
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$id]);
        
        $urlBuilder = $this->urlBuilder;
        

        //CHECK IF USER EXISTS
        if(!$user){
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

                //DELETE USER
                $userProvider = $this->gatekeeper->getUserProvider();
                $user = $userProvider->getById($id);
                $user->delete();
                
                //SET MSG
                $msg = "Account Deleted";

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

    public function resendCode(ViewFactory $view, $id)
    {
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        //USER LIST
        $user = $connection->first('SELECT * FROM users WHERE id = ?', [$id]);
        
        $urlBuilder = $this->urlBuilder;
        


        //CHECK IF USER EXISTS
        if(!$user){
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

                //RESEND CODE
                $token = $user->action_token;

                //GET EMAIL SETTINGS
                $mail_type = "user_activate";
                $mail = $connection->first('SELECT * FROM mail WHERE type = ?', [$mail_type]);


                $to = $user->email;
                $subject = $mail->subject;

                $message = $mail->body;

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // More headers
                $headers .= 'From: '. $mail->from_email . "\r\n";

                mail($to,$subject,$message,$headers);

                $msg = "Activation Code Sent";

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