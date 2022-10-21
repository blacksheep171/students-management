<?php

include dirname(__DIR__)."./Services/Services.php";

class StudentServices  extends Services {
    protected $user;
    protected $subject;
    protected $course;
    protected $exercise;
    protected $comment;

    public function __construct()
    {   
        $this->user = new UserServices();
        $this->course = new CourseServices();
        $this->exercise = new ExerciseServices();
        $this->comment = new CommentServices();
        $this->subject = new SubjectServices();
    }

    public function createExercise(){
            $input = new ExerciseServices();
            $user = $this->getCurrentUser();
            $subject = $this->getCurrentSubject();
            $input->setName($_POST['name']);
            $input->setSummary($_POST['summary']);
            $input->setContent($_POST['content']);
            $input->setStudentId($user['id']);
            $input->setCourseId($subject['course_id']);
            $input->setSubjectId($subject['id']);
            $input->setCreatedAt(date('Y-m-d H:i:s'));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));
            $upload = $this->uploadFile();
            if($upload){
                $input->setFileName($upload['file_name']);
                $input->setFilePath($upload['file_path']);
                $data = $this->exercise->create($input);
               
            } else {
                $data = [];
            }
                return $data;
    }

    public function list() {
        $data = $this->exercise->index();
        if(!empty($data)){
            return $data;
        } else {
            return [];
        }
    }
    public function getCourse(){
        $data = $this->course->get($this->getCurrentParams('id'));
        return $data;
    }
    public function getStudentSubjects(){
        $user = $this->getCurrentUser();
        $data = $this->user->getStudents($user['id'],$this->getCurrentParams('course_id'));
        if(!empty($data)){
            return $data;
        } else {
            return [];
        }
    }

    public function uploadFile(){
        $data = [];
        // declare
        $rename = time();
        $fileName = $_FILES['fileToUpload']['name'];
        $filePath = $_FILES['fileToUpload']['tmp_name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $targetDir = dirname(dirname(__DIR__))."/public/uploads/";
        $targetFile = $targetDir.basename($fileName);
        $error = [];
        $fileUrl = BASE_PATH.$fileName;
        if (empty($fileName)) {
            $error[] = 'please select an images';
        } else {
            if(file_exists($targetFile)){
                $targetFile =  $targetDir.$rename.basename($fileName);
                $fileName =  $rename.basename($fileName);
            }
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            //extension
            $extension = ['jpg', 'png', 'gif', 'jpeg','gif'];

            if (!in_array($fileExt, $extension)) {
                if (!file_exists($targetFile)) {
                    if ($fileSize < 128000000) {
                        move_uploaded_file($filePath, $targetFile);
                            $data['file_name'] = $fileName;
                            $data['file_path'] = $fileUrl;
                    } else {
                        $error[] = 'Sorry your file is too large';
                    }
                } else {
                    $error[] = 'Sorry, file already exists check upload folder';
                }
            } else {
                $error[] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed';
            }
        }

        if(empty($error)){
            return $data;
        } else {
            return $data = [];
        }
    }

    public function getComments(){
        $data = $this->comment->index();
        if(!empty($data)){
            return $data;
        } else {
            return $data = [];
        }
    }

    public function createComments() {

        $input = new CommentServices();

        $input->setContent($_POST['content']);
        $input->setExerciseId($this->getCurrentParams('exercise_id'));
        $input->setUserId($_SESSION['user']['id']);
        $input->setCreatedAt(date('Y-m-d H:i:s'));
        $input->setUpdatedAt(date('Y-m-d H:i:s'));

        $data = $this->comment->create($input);
        if(!empty($data)){
            // return $data;
            header("Location: comment-exercises.php?exercise_id=".htmlspecialchars($_POST['exercise_id']));
        } else {
            return $data = [];
        }
    }
}
