<?php

require_once dirname(__DIR__)."./Config.php";
class Users {

    private $table = "users";

    /**
     * connection to database
     * @param string
     * @return PDO
     */
    private $connection;

    private $id;
    private $name;
    private $email;
    private $password;
    private $passwordConfirm;
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
    public function setPasswordConfirm($passwordConfirm) {
        $this->passwordConfirm = $passwordConfirm;
    }
    public function getPasswordConfirm() {
        return $this->passwordConfirm;
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

    public function create($input){
        // if (!$input->isValid()) return false;
        try {
            $stmt = $this->connection->prepare("INSERT INTO ".$this->table." (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES (:name, :email, :password, :role, :createdAt, :updatedAt)");
            $data = [
                ':name' => $input->getName(),
                ':email' => $input->getEmail(),
                ':password' => md5($input->getPassword()),
                ':role' => $input->getRole(),
                ':createdAt' => $input->getCreatedAt(),
                ':updatedAt' => $input->getUpdatedAt(),
            ];
            if($stmt->execute($data)){
                return true;
            } else {
                return false;
            }

        } catch(Exception $e){
            // logError
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function index(){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM .$this->table.");
            
            if($stmt->execute()){
               $data = $stmt->fetchAll();
            } else {
                $data = [];
            }
            return $data;
        } catch(Exception $e) {
             // logError
             error_log($e->getMessage());
             return $data = [];
        }
    }

    public function getUser($id){
        try{
            $stmt = $this->connection->prepare("SELECT * FROM ".$this->table." WHERE id = :id");
            $data = [
                ':id' => $id
            ];
            $stmt->execute($data);
            $data = $stmt->fetch();
            if($stmt->rowCount() == 1) {
                return $data;
            }
        }
        
        catch(Exception $e){
             error_log($e->getMessage());
            return $data = [];
        } 
    }

    public function getUserWithRole($params = ''){
        try{
            $stmt = $this->connection->prepare("SELECT * FROM ".$this->table." WHERE role = :role");
            $data = [
                ':role' => $params
            ];
            $stmt->execute($data);
            $data = $stmt->fetchAll();        
            return $data;
        }
        
        catch(Exception $e){
             error_log($e->getMessage());
            return [];
        } 
    }

    public function logged($email,$password){
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
                return [];
            }
        
        } catch(Exception $e){
            $e->getMessage();
            return [];
        }
    }

    public function getStudentList($id){
        try {
            $sql ="SELECT * FROM subject_list WHERE `subject_id` = :subject_id";
            $stmt = $this->connection->prepare($sql);
            $data = [
                ':subject_id' => $id,
            ];
                if($stmt->execute($data)){
                    $result = $stmt->fetchAll();
                    return $result;
                } else {
                    return [];
                }
        } catch(Exception $e){
                // logError
            error_log($e->getMessage());
            return [];
        }
    }

    public function getStudents($id,$courseId){
        try {
            $sql =" SELECT * FROM subject_list WHERE `student_id` = :student_id AND `course_id` = :course_id ";
            $stmt = $this->connection->prepare($sql);
            $data = [
                ':student_id' => $id,
                ':course_id' => $courseId
            ];
                if($stmt->execute($data)){
                    $result = $stmt->fetchAll();
                    return $result;
                } else {
                    return [];
                }
        } catch(Exception $e){
            error_log($e->getMessage());
            return [];
        }
    }
}
