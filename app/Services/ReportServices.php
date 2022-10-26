<?php
include  dirname(__DIR__)."./Services/Services.php";
include  dirname(__DIR__)."./Interface/UserInterface.php";

class ReportServices extends Services implements UserInterface {

    protected $subject;
    protected $exercise;
    protected $comment;
    protected $user;
    protected $course;

    public function __construct()
    {
        $this->user = new UserServices();
        $this->subject = new SubjectServices();
        $this->comment = new CommentServices();
        $this->course = new CourseServices();
        $this->exercise = new ExerciseServices();
        $this->comment = new CommentServices();
        $this->subject = new SubjectServices();
    }
    public function getSubjects() {
        $data = $this->subject->index();
        return $data;
    }

    public function getMostSubmittedSubject(){
        $courseId = 2;
        if(isset($_SESSION['course_id'])){
            $courseId = $_SESSION['course_id'];
        }
        $data = $this->subject->getMostSubmitted($courseId);
        return $data;
    }

    public function getMostRatingSubject(){
        $courseId = 2;
        if(isset($_SESSION['course_id'])){
            $courseId = $_SESSION['course_id'];
        }
        $data = $this->subject->getMostRating($courseId);
        return $data;
        
    }

    public function getMostCommentsSubject(){
        $courseId = 2;
        if(isset($_SESSION['course_id'])){
            $courseId = $_SESSION['course_id'];
        }
        $data = $this->subject->getMostComments($courseId);
        return $data;
    }
}
