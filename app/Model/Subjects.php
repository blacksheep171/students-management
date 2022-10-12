<?php
class Subjects 
{
    private $table = "subjects";
    
    private $connection;
    public $id;
    public $title;
    public $teacherId;
    public $createdBy;
    public $createdAt;
    public $updatedAt;

    public function __construct(){
        $this->connection = Config::connect();
    }
    public function create($title,$createdBy,$createdAt,$updatedAt){
        try {
            $stmt = $this->connection->prepare("INSERT INTO ".$this->table." (`title`, `created_by`, `role`, `created_at`, `updated_at`) VALUES (:title, :created_by, :createdAt, :updatedAt)");
            $data = [
                ':title' => $title,
                ':created_by' => $createdBy,
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
}