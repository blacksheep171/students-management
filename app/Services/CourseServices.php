<?php

class CourseServices extends Courses {

    /**
     * connection to database
     * @param string
     * @return PDO
     */
    private $connection;

    protected $course;
    protected $subject;


    public function __construct() {   
        $this->course = new Courses();
        $this->connection = Config::connect();
    }

    public function create($input){
        try {
            $sql = "INSERT INTO ".$this->table." (name,created_by, status, created_at, updated_at) VALUES (:name, :created_by,:status, :created_at, :updated_at)";
            $stmt = $this->connection->prepare($sql);
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
            Log::logError($e->getMessage());
            return false;
        }
    }
    public function index(){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM ".$this->course->table);
            
            if($stmt->execute()){
                return $stmt->fetchAll();
            } else {
                return [];
            }
        } catch(Exception $e) {
             Log::logError($e->getMessage());
             return [];
        }
    }
    public function getAll(){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM course_list");
            
            if($stmt->execute()){
                return $stmt->fetchAll();
            } else {
                return false;
            }
        } catch(Exception $e) {
             // logError
             Log::logError($e->getMessage());
             return false;
        }
    }

    public function get($id){
        try{
            $sql = "SELECT * FROM ".$this->table." WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $data = [
                ':id' => $id
            ];
            $stmt->execute($data);
            $data = $stmt->fetch();
            if(!empty($data)) {
                return $data;
            } else {
                return [];
            }
        }
        catch(Exception $e){
            Log::logError($e->getMessage());
            return [];
        } 
    }
    
    public function update($input){
        try {
            $sql ="UPDATE ".$this->table." SET `status` = :status WHERE `id` = :id";
            $stmt = $this->connection->prepare($sql);
            $data = [
                ':status' => $input->getStatus(),
                ':id' => $input->getId(),
            ];
            if($stmt->execute($data)){
                return true;
            } else {
                return false;
            }
            
        } catch(Exception $e){
            Log::logError($e->getMessage());
            return false;
        }
    }
}