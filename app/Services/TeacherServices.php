<?php

include  dirname(__DIR__)."./Services/Services.php";

class TeacherServices  extends Services
{
    protected $subject;
    protected $exercise;
    protected $comment;
    protected $user;

    public function __construct()
    {
        $this->user = new UserServices();
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

        $data = $this->subject->updateSubject($input);
        if ($data) {
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
                // die();
                $checked = true;
            } else {

                $checked = false;
            }
        }
        return $checked;
    }
}
