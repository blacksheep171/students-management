<?php
include dirname(__DIR__)."./Services/Services.php";
class PresidentServices  extends Services{
    protected $course;
    protected $subject;
    protected $user;

    public function __construct()
    {   
        $this->user = new UserServices();
        $this->course = new CourseServices();
        $this->subject = new SubjectServices();
    }

    public function getCurrentSubject(){
        $data = $this->subject->get($this->getCurrentParams('subject_id'),$this->getCurrentParams('course_id'));
        if(!empty($data)){
            return $data;
        } else {
            return null;
        }
    }

    public function createCourse(){
            $input = new CourseServices();
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
        $data = $this->course->get($this->getCurrentParams('id'));
        return $data;
    }
    public function getCourses(){
        $data = $this->course->get($this->getCurrentId());
        return $data;
    }
    public function changeStatus(int $param){
        $input = new CourseServices;
        $input->setStatus($param);
        $input->setId($_POST['id']);
        $data = $this->course->update($input);
        return $data;
    }

    public function createSubject(){
        $input = new SubjectServices();
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
        $input = new SubjectServices();
        $input->setId($_POST['id']);
        $input->setTeacherId($_POST['teacher_id']);
        $input->setCreatedBy($_SESSION['user']['id']);
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