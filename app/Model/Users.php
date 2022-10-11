<?php
class Users {
    private $table = "users";

    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $createdAt;
    public $updatedAt;


    public function create($con,$name,$email,$password,$role,$createdAt,$updatedAt){
        try {
            $stmt = $con->prepare("INSERT INTO users (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES (:name, :email, :password, :role, :createdAt, :updatedAt)");
            $data = [
                ':name' => $name,
                ':email' => $email,
                ':password' => md5($password),
                ':role' => $role,
                ':createdAt' => $createdAt,
                ':updatedAt' => $updatedAt,
            ];
            if($stmt->execute($data)){
                return true;
            } else {
                return false;
            }

        } catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function index($con){
        try {
            $stmt = $con->prepare("SELECT * FROM users");
            
            if($stmt->execute()){
                return $stmt->fetchAll();
            } else {
                return false;
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
  
    function isLogin($con,$email,$password){
        try {
            $stmt = $con->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
            $data = [
                ':email' => $email,
                ':password' => md5($password)
            ];
            $stmt->execute($data);
            if($stmt->rowCount() == 1) {
                $result = $stmt->fetch();
                return $result;
            } else {
                return false;
            }
        
        } catch(Exception $e){
            return $e->getMessage();
        }
    }
}