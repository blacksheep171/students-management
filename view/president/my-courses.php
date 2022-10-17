
<?php
session_start();
include_once dirname(dirname(__DIR__))."./app/Services/PresidentServices.php";

$president = new PresidentServices();
if($president->isRole('president')) {
    $data = $president->getAllCourses();
} else {
    $data = [];
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
    .subject__list {
        display: block;
        padding: 40px 60px;
        margin: 0 auto;
    }
</style>

<div class="wrap wrap-fluid">
    <?php include dirname(__DIR__)."/header.php" ?>
    <div class="wrap__inner">
        <div class="wrap__title">
            <h1>My Courses List</h1>
        </div>
        <div class="wrap__content">
            <div class="subject__list">
            <div class="col-12">
            <table class="table table-bordered table-striped" style="margin-top:20px;">
                <thead>
                    <th>ID</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                        if(!empty($data)) {
                            foreach($data as $row){
                               if($row['status'] == 0) {
                                 $status = 'Disable';
                               } else if($row['status'] == 1){
                                $status = 'Enable';
                               }
                    ?>
                        <tr>
                            <td><?= $row['id']?></td>
                            <td><?= $row['name']?></td>
                            <td><?= $status ?></td>
                            <td>
                                <a href='<?=BASE_PATH?>/view/president/edit-course.php?id=<?=$row['id']?>' class='btn btn-success btn-sm'>Change Status</a>
                            </td>
                        </tr>
                    <?php
                            }
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
    <?php include dirname(__DIR__)."/footer.php"?>
</body>
</html>