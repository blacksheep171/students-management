<?php

include "./app/Model/Users.php";
include_once "./app/Config.php";

class UserServices {
    protected $db;
    protected $con;
    public function __construct()
    {
        $this->db = new Users();
    }

    public function setConfig(){
        $con = Config::connect();
        return $con;
    }

    public function isSession() {
        if(isset($_SESSION['user_name'])){
            return true;
        } else {
            return false;
        }
    }
    // function isRole($role) {
    //         switch($role){
    //             case 1: 
    //                 $role = 'president';
    //                 break;
    //             case 2: 
    //                 $role = 'teacher';
    //                 break;
    //             case 3: 
    //                 $role = 'student';
    //                 break;
    //             default: 
    //                 $role = '';
    //                 break;
    //     }
       
        // if(in_array($role,$roleList)){
        //     return true;
        // } else {
        //     return false;
        // }
    // }
    public function login()
    {
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userChecked = $this->db->isLogin($this->setConfig(),$email,$password);
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

    // public function login(){
    //     return $this->db->index($this->setConfig());
    // }   
    
    public function register(){
        // if(isset($_POST['save'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConfirm = $_POST['password_confirm'];
            $role = 'student';
            $createdAt = date('Y-m-d H:i:s');
            $updatedAt = date('Y-m-d H:i:s');
          
                $this->db->create($this->setConfig(),$name,$email,$password,$role,$createdAt,$updatedAt);
            //     echo "success";
            // } else {
            //     echo "failed";

            // }
        }
    // }

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