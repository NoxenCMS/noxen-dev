<?php

namespace app\controllers\admin;

use \mako\http\routing\Controller;
use \mako\view\ViewFactory;

class Groups extends Controller
{

    
    public function showGroup(ViewFactory $view, $id)
	{
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        $group = $connection->first('SELECT * FROM groups WHERE id = ?', [$id]);
        
        //CHECK IF USER EXISTS
        if(!$group){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }

        $members = $connection->all('SELECT * FROM groups_users WHERE group_id = ?', [$id]);
        $count = 0;
        foreach($members as $member){
            $count++;
        }
        $group_members = $count;
        
		return $view->create('admin/group/info', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'group' => $group,
            'group_members' => $group_members
        ));
	}
    
    public function showMembers(ViewFactory $view, $id)
	{
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);
        
        $group = $connection->first('SELECT * FROM groups WHERE id = ?', [$id]);
        
        //CHECK IF USER EXISTS
        if(!$group){
            return $view->create('admin/error/notfound', array(
                'urlBuilder' => $this->urlBuilder,
                'settings' => $settings,
            ));
            die();
        }

		return $view->create('admin/group/members', array(
            'urlBuilder' => $this->urlBuilder,
            'settings' => $settings,
            'group' => $group,
            'connection' => $connection,
            'id' => $id,
        ));
	}
    
    public function deleteGroup(ViewFactory $view, $id)
	{
        //ALLOW CONNECTION
        $connection = $this->database->connection();
        
        //APP SETTINGS
        $settings = $connection->first('SELECT * FROM settings WHERE `id` = ?', ['1']);

        $urlBuilder = $this->urlBuilder;
        
        $group = $connection->first('SELECT * FROM groups WHERE id = ?', [$id]);
        
        //CHECK IF USER EXISTS
        if(!$group){
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
                
                //PROTECT DEFAULT GROUPS
                if($id == 1){
                    $msg = "This group is protected and cannot be deleted";
                    return $view->create('admin/error/custom', array(
                        'urlBuilder' => $this->urlBuilder,
                        'settings' => $settings,
                        'session' => $this->session,
                        'token' => $token,
                        'msg' => $msg,
                    ));
                    die();
                }
                
                if($id == 2){
                    $msg = "This group is protected and cannot be deleted";
                    return $view->create('admin/error/custom', array(
                        'urlBuilder' => $this->urlBuilder,
                        'settings' => $settings,
                        'session' => $this->session,
                        'token' => $token,
                        'msg' => $msg,
                    ));
                    die();
                }
                
                //ADD TO THE DEFAULT USER GROUP
                
                $members = $connection->all('SELECT * FROM groups_users WHERE group_id = ?', [$id]);
                $userProvider = $this->gatekeeper->getUserProvider();
                $groupProvider = $this->gatekeeper->getGroupProvider();
                foreach($members as $member){
                    $member_id = $member->user_id;
                    $user = $userProvider->getById($member_id);
                    $group = $groupProvider->getByName('user');
                    $group->addUser($user);
                }
                $group->save();
                
                //DELETE USER FROM GROUP
                $group = $groupProvider->getById($id);
                $group->delete();
                
                //SET MSG
                $msg = "Group Deleted";

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