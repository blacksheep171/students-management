<?php

include_once  dirname(__DIR__)."./Services/UserServices.php";

class TeacherServices  extends UserServices{
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

    public function getAllCurrentSubjects(){
        $user = $this->getCurrentUser();
        $data = $this->subject->getAllCurrentSubjects($user['id'],2);
        if(!empty($data)){
            return $data;
        } else {
            return null;
        }
    }
    public function getStudentList()
    {
        $data = $this->user->getStudentList($this->getCurrentSubjectId());
        return $data;
    }
    public function updateSubject() {
        // $user = $this->getCurrentUser();
        $input = new Subjects();
        $input->setId($_POST['id']);
        $input->setContent($_POST['content']);
        $input->setStudentId($_POST['student_id']);
        $input->setUpdatedAt(date('Y-m-d H:i:s'));

        $data = $this->subject->updateSubject($input);
        if($data) {
            return true;
        } else {
            return false;
        }
    }

}
