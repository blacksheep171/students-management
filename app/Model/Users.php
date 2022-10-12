<?php

require_once "./app/Config.php";
class Users {
    private $table = "users";

    private $connection;

    private $id;
    private $name;
    private $email;
    private $password;
    private $role;
    private $createdAt;
    private $updatedAt;

    public function __construct() {
        $this->connection = Config::connect();
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function getPassword() {
        return $this->password;
    }
    public function setRole($role) {
        $this->role = $role;
    }
    public function getRole() {
        return $this->role;
    }
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }
    public function getCreatedAt() {
        return $this->createdAt;
    }
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function create($user){

        // if (!$user->isValid()) return false;

        try {
            $stmt = $this->connection->prepare("INSERT INTO ".$this->table." (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES (:name, :email, :password, :role, :createdAt, :updatedAt)");
            $data = [
                ':name' => $user->getName(),
                ':email' => $user->getEmail(),
                ':password' => md5($user->getPassword()),
                ':role' => $user->getRole(),
                ':createdAt' => $user->getCreatedAt(),
                ':updatedAt' => $user->getUpdatedAt(),
            ];
            if($stmt->execute($data)){
                return true;
            } else {
                return false;
            }

        } catch(Exception $e){
            // logError
            $e->getMessage();
            return false;
        }
    }
    public function index(){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM .$this->table.");
            
            if($stmt->execute()){
                return $stmt->fetchAll();
            } else {
                return false;
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function getUser($id){
        // $con = Config::connect();
        try{
            $stmt = $this->connection->prepare("SELECT * FROM ".$this->table." WHERE id = :id");
            $data = [
                ':id' => $id
            ];
            $stmt->execute($data);
            $data = $stmt->fetchAll();
            if($stmt->rowCount() == 1) {
                return $data;
            }
        }
        
        catch(Exception $e){
            // logErrorMessage($e->getMessage());
            return [
                'user_id' => '',
                'name' => '',
                'age' => 0,
            ];
        } 
    }

    public function isLogin($email,$password){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM ".$this->table." WHERE email = :email AND password = :password");
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