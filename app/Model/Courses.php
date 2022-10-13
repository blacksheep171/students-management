<?php 
require_once "./app/Config.php";

class Courses {
    private $table = 'courses';

    private $connection;
    public $id;
    public $name;
    public $createdBy;
    public $status;
    public $createdAt;
    public $updatedAt;

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
    public function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }
    public function getCreatedBy() {
        return $this->createdBy;
    }
    public function setStatus($status) {
        $this->status = $status;
    }
    public function getStatus() {
        return $this->status;
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

    public function __construct(){
        $this->connection = Config::connect();
    }
    public function create($input){
        try {
            $stmt = $this->connection->prepare("INSERT INTO ".$this->table." (name,created_by, status, created_at, updated_at) VALUES (:name, :created_by,:status, :created_at, :updated_at)");
            $data = [
                ':name' => $input->getName(),
                ':created_by' => $input->getCreatedBy(),
                ':status' => $input->getStatus(),
                ':created_at' => $input->getCreatedAt(),
                ':updated_at' => $input->getUpdatedAt()
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
            $stmt = $this->connection->prepare("SELECT * FROM ".$this->table."");
            
            if($stmt->execute()){
                return $stmt->fetchAll();
            } else {
                return false;
            }
        } catch(Exception $e) {
             // logError
             error_log($e->getMessage());
             return false;
        }
    }

    public function get($id){
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
             // logError
            error_log($e->getMessage());
            return false;
        } 
    }
}
