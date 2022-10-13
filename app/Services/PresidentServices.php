<?php

include_once "./app/Model/Courses.php";
include_once "./app/Model/Subjects.php";
include_once "./app/Services/UserServices.php";

class PresidentServices  extends UserServices{
    protected $course;
    protected $subject;
    protected $user;

    public function __construct()
    {   
        $this->user = new Users();
        $this->course = new Courses();
        $this->subject = new Subjects();
    }

    public function getCurrentUser(){
        $userData = [];
        if(isset($_SESSION['id'])){
            $userData = $this->user->getUser($_SESSION['id']);
        }
        return $userData;
    }

    public function getTeacherName($id){
        $data = $this->user->getUser($id);
        if(!empty($data)){
            return $data['name'];
        } else {
            return null;
        }
    }
    public function getCurrentId(){
        return $this->user->getCurrentId();
    }

    public function getCurrentSubject(){
        $data = $this->subject->get($this->getCurrentId());
        if(isset($data)){
            return $data;
        } else {
            return null;
        }
    }

    public function createCourse(){
            $input = new Courses();
            $user = $this->getCurrentUser();
            $input->setName($_POST['course_name']);
            $input->setStatus($_POST['status']);
            $input->setCreatedBy($user['id']);
            $input->setCreatedAt(date('Y-m-d H:i:s'));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));
          
            $data = $this->course->create($input);

            return $data;
    }
    public function getAllCourse(){
        $data = $this->course->index();
        return $data;
    }
    public function getAllTeacher(){
        $data = $this->user->getUserWithRole('teacher');
        return $data;
    }

    public function createSubject(){
        $input = new Subjects();
        $user = $this->getCurrentUser();
        $input->setTitle($_POST['title']);
        $input->setCourseId($_POST['course_id']);
        $input->setTeacherId($_POST['teacher_id']);
        $input->setCreatedBy($user['id']);
        $input->setCreatedAt(date('Y-m-d H:i:s'));
        $input->setUpdatedAt(date('Y-m-d H:i:s'));

        $data = $this->subject->create($input);
        return $data;
    }
    
    public function updateTeacher(){
        $input = new Subjects();
        $user = $this->getCurrentUser();
        $id = $this->getCurrentId();
        $input->setId($id);
        $input->setTeacherId($_POST['teacher_id']);
        $input->setCreatedBy($user['id']);
        $input->setUpdatedAt(date('Y-m-d H:i:s'));

        $data = $this->subject->updateTeacher($input);
        return $data;
    }
    public function list(){
        $data = $this->subject->index();
        if(!empty($data)){
            return $data;
        } else {
            return [];
        }
    }

    
}