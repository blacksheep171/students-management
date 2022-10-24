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

    public function getSubjectIdList(){

            $data = $this->subject->getSubjectIdList();
            if(empty($data)){
                $data = [];
            }
        
        return $data; 
    }

    public function getMostRatingSubject(){
        $ids = $this->getSubjectIdList();
        $data = [];
        $courseId = 2;
        if(!empty($ids)){
            if(isset($_SESSION['course_id'])){
                $courseId = $_SESSION['course_id'];
            }
            if($courseId){
                $offset = 0;
                $subjectId = 0;
                foreach($ids as $id){
                    $count = $this->subject->getNumberOfLikes($id,$courseId);
                    if($count >= $offset) {
                        $offset = $count;
                        $subjectId = $id;
                    }
                }
            }
            
            $data = $this->subject->get($subjectId,$courseId);

            return $data;
        }
        
    }

    public function getMostCommentsSubject(){
        $ids = $this->getSubjectIdList();
        $data = [];
        $courseId = 2;
        if(!empty($ids)){
            if(isset($_SESSION['course_id'])){
                $courseId = $_SESSION['course_id'];
            }
            if($courseId){
                $offset = 0;
                $subjectId = 0;
                foreach($ids as $id){
                    $count = $this->subject->getNumberOfComments($id,$courseId);
                    if($count >= $offset) {
                        $offset = $count;
                        $subjectId = $id;
                    }
                }
            }
            
            $data = $this->subject->get($subjectId,$courseId);

            return $data;
        }
    }
}
