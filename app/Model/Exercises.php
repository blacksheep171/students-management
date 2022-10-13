<?php 
require_once "./app/Config.php";

class Exercises {
    
    private $table = 'exercises';

    public $id;
    public $name;
    public $summary;
    public $content;
    public $fileName;
    public $filePath;
    public $courseId;
    public $studentId;
    public $subjectId;
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
    public function setSummary($summary) {
        $this->summary = $summary;
    }
    public function getSummary() {
        return $this->summary;
    }
    public function setContent($content) {
        $this->content = $content;
    }
    public function getContent() {
        return $this->content;
    }
    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }
    public function getFileName() {
        return $this->fileName;
    }
    public function setFilePath($filePath) {
        $this->filePath = $filePath;
    }
    public function getFilePath() {
        return $this->filePath;
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
    public function setSubjectId($subjectId) {
        $this->subjectId = $subjectId;
    }
    public function getSubjectId() {
        return $this->subjectId;
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
        // if (!$input->isValid()) return false;
        try {
            $stmt = $this->connection->prepare("INSERT INTO ".$this->table." (`name`, `summary`, `content`,`course_id`, `subject_id`, `created_at`, `updated_at`) VALUES (:name, :summary, :content,:course_id, :subject_id, :created_at, :updated_at)");
            $data = [
                ':name' => $input->getName(),
                ':summary' => $input->getSummary(),
                ':content' => $input->getContent(),
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
            error_log($e->getMessage());
            return false;
        }
    }
}
