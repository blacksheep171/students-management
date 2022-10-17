<?php

include_once dirname(__DIR__)."./Services/UserServices.php";

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

    public function getCurrentSubject(){
        $data = $this->subject->get($this->getCurrentSubjectId(),$this->getCurrentCourseId());
        if(!empty($data)){
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
    
    public function getCourse(){
        $data = $this->course->get($this->getCurrentId());
        return $data;
    }
    public function changeStatus(){
        $input = new Courses();
        $input->setStatus($_POST['status']);
        $input->setUpdatedAt(date('Y-m-d H:i:s'));
        $input->setId($_POST['id']);
        $data = $this->course->update($input);
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
        // $id = $this->getCurrentId();
        $input->setId($_POST['id']);
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