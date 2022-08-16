<?php

namespace App\Controllers;

use App\Models\Users;

class login extends BaseController
{
    public function __construct()
    {
        helper("userLoginData");
    }
    

    public function login()
    {

        $post = $this->request->getPost();

        if(isset($post['username']) && isset($post['password']) && $post['username'] !== '' && $post['password'] !== ''){
            $users = new Users();
            $user = $users->where('username', $post['username'])->find();
            if(isset($user[0]['username'])){

                if($post['password'] === $user[0]['password']){
                    session()->set("id", $user[0]['id']);
                    return redirect('/');
                }
            }
        }
        

        $data = [
            'title' => "Login",
            'isLoggedIn' => userLoginData(),
        ];
        
        echo view("templates/head", $data);
        echo view("templates/header");
        echo view("login/login");
    }

    public function register()
    { 
        $post = $this->request->getPost();
        if(isset($post['username']) && isset($post['password'])){
            $users = new Users();
            $existUser = $users->where('username', $post['username'])->find();
            if(!isset($existUser[0]['username'])){
                $users->insert($post);
                return redirect("/");
            }
        }

        $data = [
            'title' => "Register",
            'isLoggedIn' => userLoginData(),
        ];

        echo view("templates/head", $data);
        echo view("templates/header");
        echo view("login/register");
    }
    
    public function logout()
    {
        session_destroy();
        return redirect()->back();
    }
}