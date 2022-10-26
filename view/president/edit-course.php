
<?php
session_start();
include_once dirname(__DIR__,2)."./app/Services/PresidentServices.php";

$president = new PresidentServices();

if($president->role('president')) {
    $data = $president->getCourse();
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
.col-md-12 {
    margin-bottom: 20px;
}
</style>
<div class="wrap wrap-fluid president">
    <?php include dirname(__DIR__)."/header.php"?>
    <div class="wrap__inner president__edit-course">
        <div class="wrap__title">
            <h1>Add Courses</h1>    
        </div>
        <div class="wrap__content">
            <section class="mb-4 subject__register">
                <h2 class="h1-responsive font-weight-bold text-center my-4">New Course</h2>
                <div class="row">
                    <div class="col-md-12 mb-md-0 mb-5">
                    <?php if(isset($message)){
                            echo "<label class = 'text-danger'>".$message."</label>";
                        }
                    ?>
                        <form id="course-form" name="course-form" action="" method="POST">
                            <div class=" form-group row">
                                <div class="col-md-12">
                                    <div class="md-form mb-0">
                                        <input type="hidden" id="id" name="id" value="<?= $data['id']?>" class="form-control" placeholder="Courses id">
                                        <label for="course_name" class="">Course Name</label>
                                        <input type="text" id="course_name" name="course_name" value="<?= $data['name']?>" class="form-control" placeholder="Courses Name" required="required" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group course__status">
                                <div class="md-form mb-0">
                                    <label for="course_name" class="">Status</label>
                                </div>
                                <div class="md-form mb-0">
                                    <select class="form-select" name="status" aria-label="select" required="required" value="<?= $status = $data['status'] ?>">
                                        <option disabled selected>Please set your status</option>
                                        <option <?php if($status == 0){ echo ' selected="selected"'; } ?> id="status_1" value="0" >Disable</option>
                                        <option <?php if($status == 1){ echo ' selected="selected"'; } ?> id="status_2" value="1">Enable</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-center text-md-left">
                                <input class="btn btn-primary" name="save" type="submit" value="Save"/>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
    <?php include dirname(__DIR__)."/footer.php"?>
</body>
</html>
