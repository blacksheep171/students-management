<?php
include dirname(__DIR__).'./Config/main.php';

class UserServices {
    protected $user;
    protected $course;
    protected $subject;
    protected $exercise;

    public function __construct()
    {
        $this->user = new Users();
        $this->course = new Courses();
        $this->subject = new Subjects();
        $this->exercise = new Exercises();
    }
    public function getCurrentUser(){
        $userData = [];
        if(isset($_SESSION['user'])){
            $userData = $this->user->getUser($_SESSION['user']['id']);
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
    public function getCurrentParams(string $params){
        if(isset($_GET[$params])){
             $params = $_GET[$params];
        } 
        return $params;
    }

    public function isSession() {
        if(isset($_SESSION['user'])){
            return true;
        } else {
            return false;
        }
    }

    public function role($params = '') {
        if(isset($_SESSION['user']) && isset($_SESSION['user']['role']) && ($_SESSION['user']['role'] == $params)) {
            return true;
        } else {
            return false;
        }
    }

    public function login()
    {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userChecked = $this->user->logged($email,$password);
            if($userChecked){
                $_SESSION['user'] = $userChecked;
             
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
        $data = $this->subject->get($this->getCurrentParams('subject_id'),$this->getCurrentParams('course_id'));
        if(!empty($data)){
            return $data;
        } else {
            return null;
        }
    }
    public function getAllCurrentSubjects(){
        $user = $this->getCurrentUser();
        $data = $this->subject->getTeacherSubjects($user['id'],$this->getCurrentParams('course_id'));
        if(!empty($data)){
            return $data;
        } else {
            return null;
        }
    }
    public function getStudentList()
    {
        $data = $this->user->getStudentList($this->getCurrentParams('subject_id'));
        return $data;
    }
    public function getExercises(){
        $user = $this->getCurrentUser();
        $data = $this->exercise->getStudentExercises($this->getCurrentParams('subject_id'),$this->getCurrentParams('course_id'),$this->getCurrentParams('student_id'),);
        if(!empty($data)){
            return $data;
        } else {
            return [];
        }
    }
}