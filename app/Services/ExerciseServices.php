<?php

class ExerciseServices extends Exercises {

    /**
     * connection to database
     * @param string
     * @return PDO
     */
    private $connection;
    
    protected $exercise;

    public function __construct()
    {   
        $this->course = new Exercises();
        $this->connection = Config::connect();
    }

    public function create($input){
        // if (!$input->isValid()) return false;
        try {
            $stmt = $this->connection->prepare("INSERT INTO ".$this->table." (`name`, `summary`, `content`,`file_name`, `file_path`,`student_id`,`course_id`, `subject_id`, `created_at`, `updated_at`) VALUES (:name, :summary, :content, :file_name, :file_path, :student_id, :course_id, :subject_id, :created_at, :updated_at)");
            $data = [
                ':name' => $input->getName(),
                ':summary' => $input->getSummary(),
                ':content' => $input->getContent(),
                ':file_name' => $input->getFileName(),
                ':file_path' => $input->getFilePath(),
                ':student_id' => $input->getStudentId(),
                ':course_id' => $input->getCourseId(),
                ':subject_id' => $input->getSubjectId(),
                ':created_at' => $input->getCreatedAt(),
                ':updated_at' => $input->getUpdatedAt(),
            ];
            if($stmt->execute($data)){
                return true;
            } else {
                return false;
            }

        } catch(Exception $e){
            // logError
           Log::logError($e->getMessage());
            return false;
        }
    }

    public function index(){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM".$this->table);
            
            if($stmt->execute()){
                $data = $stmt->fetchAll();
            } else {
                $data = [];
            }
            return $data;
        } catch(Exception $e) {
             // logError
             Log::logError($e->getMessage());
             return $data = [];
        }
    }

    public function getStudentExercises($subjectId,$courseId,$studentId){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM ".$this->table." WHERE `subject_id`= :subject_id AND `course_id`= :course_id AND `student_id`= :student_id ");
            $data = [
                'subject_id' => $subjectId,
                'course_id' => $courseId,
                ':student_id' => $studentId
            ];
            if($stmt->execute($data)){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        } catch(Exception $e) {
            Log::logError($e->getMessage());
             return [];
        }
    }
    public function getVoteExercise($id){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM ".$this->table." WHERE `id`= :id");
            $data = [
                ':id' => $id
            ];
            if($stmt->execute($data)){
                $result = $stmt->fetch();
                return $result;
            } else {
                return null;
            }
        } catch(Exception $e) {
            Log::logError($e->getMessage());
             return null;
        }
    }
    public function getNumberOfSubmitted($id,$courseId){
        try{
            $sql = "SELECT COUNT(*) FROM ".$this->table." WHERE subject_id = :subject_id AND course_id = :course_id";  
            $stmt = $this->connection->prepare($sql);
            $data = [
                ':subject_id' => $id,
                ':course_id' => $courseId,
            ];
            $stmt->execute($data);
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            if(!empty($result)) {
                return $result;
            } else {
                return $result = 0;
            }
        } catch(Exception $e){
           Log::logError($e->getMessage());
            return [];
        }
    }
    public function upload($input){
        try {
            $stmt = $this->connection->prepare("INSERT INTO ".$this->table." (`file_name`, `file_path`) VALUES (:file_name, :file_path) WHERE `id` = :id");
            $data = [
                ':file_name' => $input->getFileName(),
                ':file_path' => $input->getFilePath(),
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