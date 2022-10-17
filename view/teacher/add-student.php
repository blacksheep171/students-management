<?php
session_start();
include_once  dirname(dirname(__DIR__))."/app/Services/TeacherServices.php";

$data = new TeacherServices();

$students = $data->getAllStudents();
$subject = $data->getCurrentSubject();

if (isset($_POST['save'])) {
    $data->updateSubject();
    if($data) {
        $message = 'Subject has been updated!';
    } else {
        $error = 'Something went wrong, please try later!';
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
    <title>Teacher Management</title>
</head>

<body>
    <style>
        section.mb-4.subject__register {
            display: block;
            max-width: 800px;
            margin: 0 auto;
        }

        .col-md-12 {
            margin-bottom: 20px;
        }
        .col-md-12.teacher__select {
            margin-bottom: 80px;
        }
    </style>
    <div class="wrap wrap-fluid">
        <?php include dirname(__DIR__)."/header.php" ?>
        <div class="wrap__inner">
            <div class="wrap__title">
                <h1>Course: <?= $subject['name']?></h1>
            </div>
            <div class="wrap__content">
                <section class="mb-4 subject__register">
                    <h2 class="h1-responsive font-weight-bold text-center my-4">Subject: <?= $subject['title']?></h2>
                    <h3 class="h1-responsive font-weight-bold text-center my-4">Add Your Student To Subject</h3>
                    <p class="text-center w-responsive mx-auto mb-5">Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within a matter of hours to help you.</p>
                    <div class="row">
                        <div class="col-md-12 mb-md-0 mb-5">
                            <form id="subject-form" name="subject-form" action="" method="POST">
                            <?php if(isset($message)){
                                echo '<div class="alert alert-success" role="alert">'.$message.'</div>';
                            } else if(isset($error)){
                                echo '<div class="alert alert-success" role="alert">'.$error.'</div>';
                            }
                            ?>
                                <div class="row subject__content">
                                    <div class="col-md-12">
                                        <input type="hidden" id="id" name="id" value="<?= $subject['id']?>" class="form-control" placeholder="Id">
                                        <input type="hidden" id="course_id" name="course_id" value="<?= $subject['course_id']?>" class="form-control" placeholder="Courses id">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="md-form mb-0">
                                            <label for="content">Question ?</label>
                                            <textarea type="text" id="subject__content" name="content" rows="2" class="form-control md-textarea" required="required"><?= $subject['content']?></textarea >
                                        </div>
                                    </div>
                                    <div class="col-md-12 teacher__select">
                                        <div class="md-form mb-0">
                                            <label for="course_name" class="">Student</label>
                                        </div>
                                        <div class="md-form mb-0">
                                            <select class="form-select" name="student_id" aria-label="select" required="required">
                                                <option disabled selected>Do you want to add new student for this subject?</option>
                                                <?php
                                                foreach ($students as $student) { ?>
                                                    <option id="student_<?= $student['id'] ?>" value="<?= $student['id'] ?>"><?= $student['name'] ?></option>;
                                                <?php  }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center text-md-left">
                                    <input class="btn btn-primary" name="save" type="submit" value="Save" />
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php include dirname(__DIR__)."/footer.php" ?>
</body>
</html>
