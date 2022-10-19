<?php
require_once dirname(__DIR__)."./Config.php";

class Subjects 
{
    private $table = "subjects";
    
    /**
     * connection to database
     * @param string
     * @return PDO
     */
    private $connection;

    private $id;
    private $title;
    private $content;
    private $courseId;
    private $studentId;
    private $teacherId;
    private $createdBy;
    private $createdAt;
    private $updatedAt;
    
    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }
    public function setTitle($title) {
        $this->title = $title;
    }
    public function getTitle() {
        return $this->title;
    }
    public function setContent($content) {
        $this->content = $content;
    }
    public function getContent() {
        return $this->content;
    }
    public function setCourseId($courseId) {
        $this->courseId = $courseId;
    }
    public function getCourseId() {
        return $this->courseId;
    }
    public function setStudentId($studentId) {
        $this->studentId = $studentId;
    }
    public function getStudentId() {
        return $this->studentId;
    }
    /**
     * @param string $teacherId
     * @return Subjects
     */
    public function setTeacherId($teacherId) {
        $this->teacherId = $teacherId;
    }
    public function getTeacherId() {
        return $this->teacherId;
    }
    public function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }
    public function getCreatedBy() {
        return $this->createdBy;
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
            $sql1 ="INSERT INTO ".$this->table." (`title`, `teacher_id`,`created_by`, `created_at`, `updated_at`) VALUES (:title, :teacher_id, :created_by, :created_at, :updated_at)";
            $stmt = $this->connection->prepare($sql1);
            $data1 = [
                ':title' => $input->getTitle(),
                ':teacher_id' => $input->getTeacherId(),
                ':created_by' => $input->getCreatedBy(),
                ':created_at' => $input->getCreatedAt(),
                ':updated_at' => $input->getUpdatedAt(),
            ];
            if($stmt->execute($data1)){
                $sql2 = "INSERT INTO course_subjects (`course_id`,`subject_id`,`created_at`,`updated_at`) VALUES (:course_id,:subject_id,:createdAt,:updateAt)";
                $stmt = $this->connection->prepare($sql2);
                $data2 = [
                    ':course_id' => $input->getCourseId(),
                    ':subject_id' => $this->connection->lastInsertId(),
                    ':createdAt' => $input->getCreatedAt(),
                    ':updateAt' => $input->getUpdatedAt(),
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
              // logError
            error_log($e->getMessage());
            return false;
        }
    }

    public function index(){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM courses_subjects ORDER BY subject_id");
            
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
    
    public function getTeacherSubjects($teacherId,$courseId){
        try{
            $stmt = $this->connection->prepare("SELECT * FROM courses_subjects WHERE (teacher_id = :teacher_id AND course_id = :course_id)");
            $data = [
                ':teacher_id' => $teacherId,
                ':course_id' => $courseId,
            ];
            $stmt->execute($data);
            $data = $stmt->fetchAll();
            if(!empty($data)) {
                return $data;
            } else {
                return $data = [];
            }
        }
        
        catch(Exception $e){
             // logError
             error_log($e->getMessage());
            //  return false;
            return $data = [];
        } 
    }
    public function get($id,$courseId){
        try{
            $stmt = $this->connection->prepare("SELECT * FROM courses_subjects WHERE (id = :id AND course_id = :course_id)");
            $data = [
                ':id' => $id,
                ':course_id' => $courseId,
            ];
            $stmt->execute($data);
            $data = $stmt->fetch();
            if(!empty($data)) {
                return $data;
            } else {
                return $data = [];
            }
        }
        
        catch(Exception $e){
             error_log($e->getMessage());
            //  return false;
            return $data = [];
        } 
    }

    public function updateTeacher($input){
        try {
            $sql1 ="UPDATE ".$this->table." SET `teacher_id` = :teacher_id,`created_by` = :created_by , `updated_at` = :updated_at WHERE `id` = :id";
            $stmt = $this->connection->prepare($sql1);
            $data = [
                ':teacher_id' => $input->getTeacherId(),
                ':created_by' => $input->getCreatedBy(),
                ':updated_at' => $input->getUpdatedAt(),
                ':id' => $input->getId(),
            ];
            if($stmt->execute($data)){
                return true;
            } else {
                return false;
            }
            
        } catch(Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateSubject($input){
        try {
            $sql1 ="UPDATE ".$this->table." SET `content` = :content,`updated_at` = :updated_at WHERE `id` = :id ";
            $stmt = $this->connection->prepare($sql1);
            $data1 = [
                ':content' => $input->getContent(),
                ':updated_at' => $input->getUpdatedAt(),
                ':id' => $input->getId(),
            ];
            if($stmt->execute($data1)){
                $sql2 = "INSERT INTO student_subjects (`student_id`,`subject_id`,`created_at`,`updated_at`) VALUES (:student_id,:subject_id,:created_at,:updated_at)";
                $stmt = $this->connection->prepare($sql2);
                $data2 = [
                    ':student_id' => $input->getStudentId(),
                    ':subject_id' => $input->getId(),
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