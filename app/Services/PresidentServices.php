<?php

include_once "./app/Model/Courses.php";
include_once "./app/Services/UserServices.php";

class PresidentServices  extends UserServices{
    protected $course;
    protected $user;
    protected $connection;
    public function __construct()
    {
        $this->user = new Users();
        $this->course = new Courses();
        $this->connection = Config::connect();
    }

    // public function setConfig(){
    //     $con = Config::connect();
    //     return $con;
    // }
    public function getCurrentUser(){
        $userData = [];
        if(isset($_SESSION['id'])){
            $userData = $this->user->getUser($_SESSION['id']);
        }
        return $userData;
    }
    public function createCourse(){
            $data = $this->getCurrentUser();
            $courseName = $_POST['course_name'];
            $courseStatus = 1;
            $createdBy = $data[0]['id'];
            $createdAt = date('Y-m-d H:i:s');
            $updatedAt = date('Y-m-d H:i:s');
          
            $data = $this->course->create($this->connection, $courseName, $createdBy, $courseStatus, $createdAt, $updatedAt);

            return $data;
    }
    public function getCourse(){
        $data = $this->course->index($this->connection);
        return $data;
    }

    public function createSubject(){
        $data = $this->getCurrentUser();
        
    }
}