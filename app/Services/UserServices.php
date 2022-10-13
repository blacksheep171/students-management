<?php

include "./app/Model/Users.php";
include_once "./app/Config.php";

class UserServices {
    protected $user;

    public function __construct()
    {
        $this->user = new Users();
    }
    public function getCurrentUser(){
        $userData = [];
        if(isset($_SESSION['id'])){
            $userData = $this->user->getUser($_SESSION['id']);
        }
        return $userData;
    }

    public function getCurrentId(){
        return $this->user->getCurrentId();
    }

    public function isSession() {
        if(isset($_SESSION['user_name'])){
            return true;
        } else {
            return false;
        }
    }
       
    public function login()
    {
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userChecked = $this->user->isLogin($email,$password);
            if($userChecked){
                $_SESSION['user_name'] = $userChecked['name'];
                $_SESSION['id'] = $userChecked['id'];
                $_SESSION['role'] = $userChecked['role'];
                header("Location:index.php");
            } else {
                $message[] = "login failed";
            }
        }
    }
    
    public function register(){
            $user = new Users();
            
            $user->setName($_POST['name']);
            $user->setEmail( $_POST['email']);
            $user->setPassword($_POST['password']);
            // $passwordConfirm = $_POST['password_confirm'];
            $user->setRole($_POST['role']);
            $user->setCreatedAt(date('Y-m-d H:i:s'));
            $user->setUpdatedAt(date('Y-m-d H:i:s'));
          
            $data =  $this->db->create($user);
            return $data;
    }

    // public function validated() {
    //     $name = '';
    //     $email = '';
    //     $password = '';
    //     $passwordConfirm = '';
    //     $errorMessages = [];

    //     if (isset($_POST['name'])) {
    //         $name = $_POST['name'];
    //         if(empty($name)){
    //             $errorMessages[0] = "Name required";
    //         }
    //     }
    //     if(isset($_POST['email'])){
    //         $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    //         if(empty($email)){
    //             $errorMessages[1] = "Email required";
    //         }
    //     }
    //     if(isset($_POST['password']) && isset($_POST['password_confirm'])){
    //         $password = strip_tags($_POST['password']);
    //         $passwordConfirm = $_POST['password_confirm'];

    //         if(empty($password)){
    //             $errorMessages[2] = "Password required";
    //         } else if(strlen($password) < 6 ){
    //             $errorMessages[2] = "Password must be at least 6 characters";
    //         }
    //         if(empty($passwordConfirm)){
    //             $errorMessages[3] = "Confirm password required";
    //         } else if($password !== $passwordConfirm) {
    //             $errorMessages[3] = "Confirm password not correct";
    //         }
    //     }
    //     return $errorMessages;
    // }
    
}