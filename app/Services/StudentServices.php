<?php

include_once dirname(__DIR__)."./Services/UserServices.php";

class StudentServices  extends UserServices{
    protected $user;
    protected $subject;
    protected $exercise;
    protected $comment;
    

    public function __construct()
    {   
        $this->user = new Users();
        $this->exercise = new Exercises();
        $this->comment = new Comments();
        $this->subject = new Subjects();
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
               
            } else {
                $data = [];
            }
                return $data;
    }

    public function uploadFile(){
        $data = [];
        // declare
        $rename = time();
        $fileName = $_FILES['fileToUpload']['name'];
        $filePath = $_FILES['fileToUpload']['tmp_name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $targetDir = "public/uploads/";
        $targetFile = $targetDir.basename($fileName);
        $error = [];
        $fileUrl = BASE_PATH.$targetFile;
        if (empty($fileName)) {
            $error[] = 'please select an images';
        } else {
            if(file_exists($targetFile)){
                $targetFile =  $targetDir.$rename.basename($fileName);
            }
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            //extension
            $extension = ['jpg', 'png', 'gif', 'jpeg','gif'];

            if (!in_array($fileExt, $extension)) {
                if (!file_exists($targetFile)) {
                    if ($fileSize < 128000000) {
                        move_uploaded_file($filePath, $targetFile);
                            $data['file_name'] =  $rename.basename($fileName);
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
