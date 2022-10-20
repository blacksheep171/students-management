<?php

class CommentServices extends Comments {

    /**
     * connection to database
     * @param string
     * @return PDO
     */
    private $connection;

    protected $user;
    protected $course;
    protected $subject;
    protected $exercise;
    protected $comment;

    public function __construct()
    {   
        $this->comment = new Comments();
        $this->connection = Config::connect();
    }

    public function index(){
        try {
            $sql = "SELECT * FROM comment_list";
            $stmt = $this->connection->prepare($sql);
            
            if($stmt->execute()){
               $data = $stmt->fetchAll();
            } else {
                $data = [];
            }
            return $data;
        } catch(Exception $e) {
             error_log($e->getMessage());
             return $data = [];
        }
    }

    public function create($input){
        try {
            $sql1 ="INSERT INTO ".$this->table." (`content`, `user_id`, `created_at`, `updated_at`) VALUES (:content, :user_id, :created_at, :updated_at)";
            $stmt = $this->connection->prepare($sql1);
            $data1 = [
                ':content' => $input->getContent(),
                ':user_id' => $input->getUserId(),
                ':created_at' => $input->getCreatedAt(),
                ':updated_at' => $input->getUpdatedAt(),
            ];
            if($stmt->execute($data1)){
                $sql2 = "INSERT INTO comment_exercises ( `comment_id`, `exercise_id`, `created_at`, `updated_at`) VALUES ( :comment_id, :exercise_id, :created_at, :updated_at)";
                $stmt = $this->connection->prepare($sql2);
                $data2 = [
                    ':comment_id' =>  $this->connection->lastInsertId(),
                    ':exercise_id' =>$input->getExerciseId(),
                    ':created_at' => $input->getCreatedAt(),
                    ':updated_at' => $input->getUpdatedAt(),
                ];
                if($stmt->execute($data2)){
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch(Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }
}