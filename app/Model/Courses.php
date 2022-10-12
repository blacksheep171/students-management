<?php 

class Courses {
    private $table = 'courses';

    private $connection;
    public $id;
    public $name;
    public $createdBy;
    public $status;
    public $createdAt;
    public $updatedAt;

    public function __construct(){
        $this->connection = Config::connect();
    }
    public function create($name,$createdBy,$status,$createdAt,$updatedAt){
        try {
            $stmt = $this->connection->prepare("INSERT INTO ".$this->table." (name,created_by, status, created_at, updated_at) VALUES (:name, :created_by,:status, :created_at, :updated_at)");
            $data = [
                ':name' => $name,
                ':created_by' => $createdBy,
                ':status' => $status,
                ':created_at' => $createdAt,
                ':updated_at' => $updatedAt,
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
    public function index(){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM ".$this->table."");
            
            if($stmt->execute()){
                return $stmt->fetchAll();
            } else {
                return false;
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function getCourse($id){

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
            return $e->getMessage();
        } 
    }
}
