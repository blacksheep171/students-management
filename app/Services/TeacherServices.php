<?php

include  dirname(__DIR__)."./Services/Services.php";

class TeacherServices  extends Services
{
    protected $subject;
    protected $exercise;
    protected $comment;
    protected $user;
    protected $course;

    public function __construct()
    {
        $this->user = new UserServices();
        $this->course = new CourseServices();
        $this->exercise = new ExerciseServices();
        $this->comment = new CommentServices();
        $this->subject = new SubjectServices();
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

    public function updateSubject()
    {
        $input = new Subjects();
        $input->setId($_POST['id']);
        $input->setContent($_POST['content']);
        $input->setStudentId($_POST['student_id']);
        $input->setUpdatedAt(date('Y-m-d H:i:s'));
        if($this->validateStudents()){
            $data = $this->subject->updateSubject($input);
        } else {
            $data = [];
        }
        if (!empty($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function downloadFile()
    {   
        $checked = false;
        if (isset($_GET['path'])) {
            $file = $_GET['path'];
            $targetDir = dirname(dirname(__DIR__))."/public/uploads/";
            $fileName = $targetDir.basename($file);
            //Clear the cache
            clearstatcache();
            //Check the file path exists or not
            if (file_exists($fileName)) {
                //Define header information
                header("Cache-Control: public");
                header('Content-Description: File Transfer');
                header('Content-Disposition: attachment; filename="'.$file.'"');
                header('Content-Type: application/zip');
                header('Content-Transfer-Emcoding: binary');
                //Clear system output buffer
                flush();
                //Read the size of the file
                readfile($fileName, true);
                $checked = true;
            } else {
                Log::logError("Cannot Download this file!");
                $checked = false;
            }
        }
        return $checked;
    }

    public function validateStudents(){
        $studentId = $_POST['student_id'];
        $courseId = $_SESSION['course_id'];
        $subjectId = $this->getCurrentParams('subject_id');
        $students = $this->user->getStudentSubject($studentId,$courseId,$subjectId);
        if(empty($students)){
            return true;
        } else {
            Log::logError("Student Already Exists!");
            return false;
        }
    }
}
