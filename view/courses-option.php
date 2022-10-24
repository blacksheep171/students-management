<?php
session_start();
include_once dirname(__DIR__)."./app/Services/Services.php";

$data = new Services();
$courses = $data->getAllCourses();

if (isset($_GET['save'])) {
    if(isset($_GET['course_id'])){
        $_SESSION['course_id'] = $_GET['course_id'];
        if($data->role('teacher')){
            header("Location: teacher/subjects.php?course_id=".$_SESSION['course_id']);
        } else if($data->role('student')) {
            header("Location: student/subjects.php?course_id=".$_SESSION['course_id']);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?=BASE_PATH?>./public/css/style.css" />
    <link rel="stylesheet/less" type="text/css" href="<?=BASE_PATH?>./public/css/sources/styles.less" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Roboto&display=swap" rel="stylesheet">
    <script rel="preload" as="script" crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.min.js"></script>
    <title>Courses Management</title>
</head>

<body>
    <div class="wrap wrap-fluid courses">
        <?php include  __DIR__."/header.php" ?>
        <div class="wrap__inner courses__list">
            <div class="wrap__title">
                <h1>Courses</h1>
            </div>
            <div class="wrap__content">
                <section class="mb-4 subject__register">
                    <h2 class="h1-responsive font-weight-bold text-center my-4">Choose your current Course</h2>
                    <p class="text-center w-responsive mx-auto mb-5">Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within a matter of hours to help you.</p>
                    <div class="row">
                        <div class="col-md-12 mb-md-0 mb-5">
                            <form id="subject-form" name="subject-form" action="" method="GET">
                            <?php if(isset($message)){
                                echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
                                }
                            ?>
                                <div class="row subject__content">
                                    <div class="col-md-12">
                                    </div>
                                    <div class="col-md-12 courses__select">
                                        <div class="md-form mb-0">
                                            <label for="course_name" class="">Courses</label>
                                        </div>
                                        <div class="md-form mb-0">
                                            <select class="form-select" name="course_id" aria-label="select" required="required">
                                                <option disabled selected>Please choose your courses</option>
                                                <?php
                                                foreach ($courses as $course) { ?>
                                                    <option id="teacher_<?= $course['id'] ?>" value="<?= $course['id'] ?>"><?= $course['name'] ?></option>;
                                                <?php  
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center text-md-left">
                                    <input type="submit" name="save" class="btn btn-primary" value="save"/> 
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php include __DIR__."/footer.php" ?>
</body>
</html>
