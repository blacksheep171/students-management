<?php
session_start();
include_once dirname(dirname(__DIR__))."./app/Services/StudentServices.php";

$user = new StudentServices();

if($user->role('student')) {
    $subject = $user->getCurrentSubject();

    if (isset($_POST['save'])) {
        if(!empty($_FILES)) {
            $data = $user->createExercise();
        }
        if (!empty($data)) {
            $message = 'Submit successfully!';
            header("Location: subject-details.php?subject_id=".$subject['id']."&course_id=".$_SESSION['course_id']);
        } else {
            $error = 'Submit failed!';
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
    <title>Student Management</title>
</head>

<body>
    <style>
        section.mb-4.subject__register {
            display: block;
            max-width: 800px;
            margin: 0 auto;
        }

        .row.exercises__content {
            margin-bottom: 20px;
        }
    </style>
    <div class="wrap wrap-fluid">
        <?php include dirname(__DIR__)."/header.php" ?>
        <div class="wrap__inner">
            <div class="wrap__title">
                <h1>Submit Exercises</h1>
            </div>
            <div class="wrap__content">
                <section class="mb-4 subject__register">
                    <h2 class="h1-responsive font-weight-bold text-center my-4"><?= $subject['title'] ?></h2>
                    <p class="text-center w-responsive mx-auto mb-5"><?= $subject['content'] ?></p>
                    <div class="row">
                        <div class="col-md-12 mb-md-0 mb-5">
                            <form id="exercises-form" name="exercises-form" action="" method="POST" enctype='multipart/form-data'>
                            <?php if(isset($message)){
                                echo '<div class="alert alert-success" role="alert">'.$message.'</div>';
                            } else if(isset($error)){
                                echo '<div class="alert alert-success" role="alert">'.$error.'</div>';
                            }
                            ?>
                                <div class="row exercises__content">
                                    <div class="col-md-12">
                                        <div class="md-form mb-0">
                                            <label for="name" class="">Name</label>
                                            <input type="hidden" id="course_id" name="course_id" value="<?=$_SESSION['course_id'] ?>" class="form-control" required="required">
                                            <input type="text" id="name" name="name" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row exercises__content">
                                    <div class="col-md-12">
                                        <div class="md-form mb-0">
                                            <label for="summary" class="">Summary</label>
                                            <input type="text" id="summary" name="summary" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row exercises__content">
                                    <div class="col-md-12">
                                        <div class="md-form mb-0">
                                            <label for="content">Content</label>
                                            <textarea type="text" id="content" name="content" rows="2" class="form-control md-textarea" required="required"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row exercises__content">
                                    <div class="col-md-12">
                                        <div class="md-form mb-0">
                                            <label for="content">Upload</label>
                                            <input type="file" name="fileToUpload" value="" id="fileToUpload" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center text-md-left">
                                    <input type="submit" class="btn btn-primary" name="save" value="Submit" />
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
