<?php
include dirname(__DIR__).'./Config/main.php';

class UserServices {
    protected $user;
    protected $course;
    protected $subject;

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

    public function getCurrentId(){
        $id = 0;
        if(isset($_GET['id'])){
             $id = $_GET['id'];
        } 
        return $id;
    }
    public function getCurrentSubjectId(){
        $id = 0;
        if(isset($_GET['subject_id'])){
             $id = $_GET['subject_id'];
        } 
        return $id;
    }
    public function isSession() {
        if(isset($_SESSION['user_name'])){
            return true;
        } else {
            return false;
        }
    }

    public function isRole($params = '') {
        if(isset($_SESSION['user_name']) && isset($_SESSION['role']) && ($_SESSION['role'] == $params)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getCurrentCourseId(){
        $courseId = 0;
        if(isset($_GET['course_id'])){
             $courseId = $_GET['course_id'];
        } 
        return $courseId;
    }

    public function login()
    {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userChecked = $this->user->isLogin($email,$password);
            if($userChecked){
                $_SESSION['user_name'] = $userChecked['name'];
                $_SESSION['id'] = $userChecked['id'];
                $_SESSION['role'] = $userChecked['role'];
                header("Location:index.php");
            } else {
                error_log($message = "Login failed, please try again!");
            }
    }
    
    public function register(){
            $user = new Users();
            
            $user->setName($_POST['name']);
            $user->setEmail( $_POST['email']);
            $user->setPassword($_POST['password']);
            // $passwordConfirm = $_POST['password_confirm'];
            $user->setRole($_POST['role']);
            $user->setCreatedAt(date('Y-m-d H:i:s'));
            $user->setUpdatedAt(date('Y-m-d H:i:s'));
          
            $data =  $this->user->create($user);
            return $data;
    }

    public function getTeacherName($id){
        $data = $this->user->getUser($id);
        if(!empty($data)){
            return $data['name'];
        } else {
            return null;
        }
    }
    public function getAllCourses(){
        $data = $this->course->index();
        if(!empty($data)){
            return $data;
        } else {
            return [];
        }
    }
    public function list(){
        $data = $this->subject->index();
        if(!empty($data)){
            return $data;
        } else {
            return [];
        }
    }
    
    public function getAllTeachers(){
        $data = $this->user->getUserWithRole('teacher');
        return $data;
    }
    public function getAllStudents(){
        $data = $this->user->getUserWithRole('student');
        return $data;
    }

    public function getCurrentSubject(){
        $data = $this->subject->get($this->getCurrentSubjectId(),$this->getCurrentCourseId());
        if(!empty($data)){
            return $data;
        } else {
            return null;
        }
    }
}