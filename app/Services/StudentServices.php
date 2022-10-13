<?php

include_once "./app/Model/Subjects.php";
include_once "./app/Model/Exercises.php";
include_once "./app/Model/Comments.php";
include_once "./app/Services/UserServices.php";

class StudentServices  extends UserServices{
    protected $subject;
    protected $exercise;
    protected $comment;
    protected $user;

    public function __construct()
    {   
        $this->user = new Users();
        $this->exercise = new Exercises();
        $this->comment = new Comments();
        $this->subject = new Subjects();
    }

    public function getTeacherName($id){
        $data = $this->user->getUser($id);
        if(!empty($data)){
            return $data['name'];
        } else {
            return null;
        }
    }

    public function getCurrentSubject(){
        $data = $this->subject->get($this->getCurrentId());
        if(isset($data)){
            return $data;
        } else {
            return null;
        }
    }

    public function createExercise(){
            $input = new Exercises();
            $user = $this->getCurrentUser();
            $input->setName($_POST['name']);
            $input->setSummary($_POST['summary']);
            $input->setContent($_POST['content']);
            // $input->setCourseId();
            // $input->setSubjectId();
            $input->setCreatedAt(date('Y-m-d H:i:s'));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));
          
            $data = $this->exercise->create($input);

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
