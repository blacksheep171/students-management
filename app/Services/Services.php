<?php
include dirname(__DIR__) . './Config/main.php';
class Services
{
    protected $user;
    protected $course;
    protected $subject;
    protected $exercise;
    protected $comment;

    public function __construct()
    {
        $this->user = new UserServices();
        $this->course = new CourseServices();
        $this->subject = new SubjectServices();
        $this->exercise = new ExerciseServices();
        $this->comment = new CommentServices();
    }
    public function getCurrentUser()
    {
        $userData = [];
        if (isset($_SESSION['user'])) {
            $userData = $this->user->getUser($_SESSION['user']['id']);
        }
        return $userData;
    }

    public function getCurrentId()
    {
        $id = 0;
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
        }
        return $id;
    }
    public function getCurrentParams(string $params)
    {
        if (isset($_GET[$params])) {
            $params = $_GET[$params];
        }
        return $params;
    }

    public function loggedIn()
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

    public function role($params = '')
    {
        if (isset($_SESSION['user']) && isset($_SESSION['user']['role']) && ($_SESSION['user']['role'] == $params)) {
            return true;
        } else {
            return false;
        }
    }

    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $userChecked = $this->user->logged($email, $password);
        if ($userChecked) {
            $_SESSION['user'] = $userChecked;
            header("Location:index.php");
        } else {
            error_log($message = "Login failed, please try again!");
        }
    }

    public function register()
    {
        $user = new Users();

        $user->setName($_POST['name']);
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->setRole($_POST['role']);
        $user->setCreatedAt(date('Y-m-d H:i:s'));
        $user->setUpdatedAt(date('Y-m-d H:i:s'));

        $data =  $this->user->create($user);
        return $data;
    }

    public function getTeacherName($id)
    {
        $data = $this->user->getUser($id);
        if (!empty($data)) {
            return $data['name'];
        } else {
            return null;
        }
    }
    public function getAllCourses()
    {
        $data = $this->course->index();
        if (!empty($data)) {
            return $data;
        } else {
            return [];
        }
    }

    public function list()
    {   
        $courseId = 2;
        if(isset($_SESSION['course_id'])){
            $courseId = $_SESSION['course_id'];
        }
        $data = $this->subject->getCurrentCourseSubjects($courseId);
        if (!empty($data)) {
            return $data;
        } else {
            return [];
        }
    }

    public function getAllTeachers()
    {
        $data = $this->user->getUserWithRole('teacher');
        return $data;
    }
    public function getAllStudents()
    {
        $data = $this->user->getUserWithRole('student');
        return $data;
    }

    public function getCurrentSubject()
    {
        $data = $this->subject->get($this->getCurrentParams('subject_id'), $this->getCurrentParams('course_id'));
        if (!empty($data)) {
            return $data;
        } else {
            return null;
        }
    }
    public function getAllCurrentSubjects()
    {
        $user = $this->getCurrentUser();
        $data = $this->subject->getTeacherSubjects($user['id'], $this->getCurrentParams('course_id'));
        if (!empty($data)) {
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
    public function getExercises()
    {
        $user = $this->getCurrentUser();
        $data = $this->exercise->getStudentExercises($this->getCurrentParams('subject_id'), $this->getCurrentParams('course_id'), $this->getCurrentParams('student_id'));
        if (!empty($data)) {
            return $data;
        } else {
            return [];
        }
    }
    public function getVoteExercise($id)
    {
        $user = $this->getCurrentUser();
        $data = $this->exercise->getVoteExercise($id);
        if (!empty($data)) {
            return $data;
        } else {
            return [];
        }
    }

    public function getCommentList()
    {
        $data = $this->comment->getExerciseComments($this->getCurrentParams('exercise_id'));
        if (!empty($data)) {
            return $data;
        } else {
            return null;
        }
    }

    public function vote($status, $id)
    {
        $input = new UserServices();

        $input->setId($_SESSION['user']['id']);
        $input->setExerciseId($id);
        $input->setVoteStatus($status);
        $input->setCreatedAt(date('Y-m-d H:i:s'));
        $input->setUpdatedAt(date('Y-m-d H:i:s'));
        if($this->user->voted($input)){
            $data = $this->user->updateVote($input);
        } else {
            $data = $this->user->vote($input);
        }

        if (($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function unVote($id)
    {
        $input = new UserServices();

        $input->setId($_SESSION['user']['id']);
        $input->setExerciseId($id);

        $data = $this->user->unVote($input);

        if (($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function userLike($id)
    {
        $input = new UserServices();

        $input->setId($_SESSION['user']['id']);
        $input->setExerciseId($id);
        $data = $this->user->userLike($input);

        if ($data) {
            return true;
        } else {
            return false;
        }
    }
    public function userDisLike($id)
    {
        $input = new UserServices();

        $input->setId($_SESSION['user']['id']);
        $input->setExerciseId($id);

        $data = $this->user->userDisLike($input);

        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function getLikes($id)
    {
        $data = $this->user->getLikes($id);
        if ($data) {
            return $data;
        } else {
            return $data = 0;
        }
    }

    public function getDisLikes($id)
    {;
        $data = $this->user->getDisLikes($id);
        if ($data) {
            return $data;
        } else {
            return $data = 0;
        }
    }

    public function permission()
    {
        $courseId = $_SESSION['course_id'];
        $data = $this->course->get($courseId);
        if (!empty($data)) {
            $status = $data['status'];
            if ($status == 1) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function getCountSubmitSubject($id){
        $courseId = 2;
        if(isset($_SESSION['course_id'])){
            $courseId = $_SESSION['course_id'];
        }
        $data = null;
        if($courseId){
            $data = $this->exercise->getNumberOfSubmitted($id,$courseId);
        }
        return $data;
    }

    public function getCountLikesSubject($id){
        $courseId = 2;
        if(isset($_SESSION['course_id'])){
            $courseId = $_SESSION['course_id'];
        }
        $data = null;
        if($courseId){
            $data = $this->subject->getNumberOfLikes($id,$courseId);
        }
        return $data;
    }
    public function getCountCommentsSubject($id){
        $courseId = 2;
        if(isset($_SESSION['course_id'])){
            $courseId = $_SESSION['course_id'];
        }
        $data = null;
        if($courseId){
            $data = $this->subject->getNumberOfComments($id,$courseId);
        }
        return $data;
    }
}
