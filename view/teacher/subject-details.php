
<?php
session_start();
include_once dirname(dirname(__DIR__))."./app/Services/TeacherServices.php";

$user = new TeacherServices();

if($user->role('teacher')) {
    $data = [];
    $permission = $user->permission();
    if(!empty($user->getCurrentSubject())){
        $data = $user->getCurrentSubject();
        $students = $user->getStudentList();
    }
} else {
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?=BASE_PATH?>./public/css/style.css"/>
    <link rel="stylesheet/less" type="text/css" href="<?=BASE_PATH?>./public/css/sources/styles.less"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Roboto&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script rel="preload" as="script" crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.min.js"></script>
    <title>Subject Details</title>
</head>
<body>

<div class="wrap wrap-fluid teacher">
    <?php include  dirname(__DIR__)."/header.php" ?>
    <div class="wrap__inner teacher__subject-details">
        <div class="wrap__title">
            <h1>My Subject: <?=$data['title']?></h1>
        </div>
        <div class="wrap__content">
            <div class="subject__list">
                <div class="col-3">
                <a id="add_student" data-type="2" href='edit-subjects.php?subject_id=<?=$data['subject_id']?>&course_id=<?=$data['course_id']?>' class='btn btn-primary btn-sm'>Add Student</a>
                </div>
            <div class="col-12">
            <table class="table table-bordered table-striped" style="margin-top:20px;">
                <thead>
                    <th>ID</th>
                    <th>Student</th>
                    <th>Subject Content</th>
                    <th>Note</th>
                </thead>
                <tbody>
                    <?php foreach ($students as $student){
                    ?>
                    <tr>
                        <td><?= $student['student_id'] ?></td>
                        <td><?= $student['student_name'] ?></td>
                        <td><?= $student['content'] ?></td>
                        <td>
                            <a href='<?=BASE_PATH?>view/exercise-details.php?subject_id=<?=$student['subject_id']?>&course_id=<?=$student['course_id']?>&student_id=<?=$student['student_id']?>' class='btn btn-outline-primary btn-sm'>Exercise</a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>  
                </tbody>
            </table>
        </div>
            </div>
        </div>
    </div>
</div>

</div>
    <?php include  dirname(__DIR__)."/footer.php"?>
</body>
<script>
$(document).ready(function() {
    var courseStatus = <?= $permission?>;
    $('#add_student').click(function(e) {
        if(courseStatus == 0) {
            e.preventDefault();
            alert("You don't have permission.");
        }
    });
});

</script>
</html>
