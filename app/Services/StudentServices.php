<?php

include_once "./app/Model/Subjects.php";
include_once "./app/Model/Exercises.php";
include_once "./app/Model/Comments.php";
include_once "./app/Services/UserServices.php";

class StudentServices  extends UserServices{
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

    public function getCurrentSubject(){
        $data = $this->subject->get($this->getCurrentSubjectId(),$this->getCurrentCourseId());
        if(!empty($data)){
            return $data;
        } else {
            return null;
        }
    }

    public function createExercise(){
            $input = new Exercises();
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
                echo 'success';
            } else {
                echo 'error';
            }
                // return $data;
    }

    public function uploadFile(){
        $data = [];
        $targetDir = "public/uploads/";
        $targetFile = $targetDir.basename($_FILES["fileToUpload"]["name"]);
        // declare
        $fileName = $_FILES['fileToUpload']['name'];
        $filePath = $_FILES['fileToUpload']['tmp_name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $error = [];
        $fileUrl = BASE_PATH.$targetFile;
        if (empty($fileName)) {
            $error[] = 'please select an images';
        } else {
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            //extension
            $extension = ['jpg', 'png', 'gif', 'jpeg','gif'];

            if (!in_array($fileExt, $extension)) {
                if (!file_exists($targetDir.$fileName)) {
                    if ($fileSize < 5000000) {
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
}
