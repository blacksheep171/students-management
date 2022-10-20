
<?php
session_start();

include_once dirname(__DIR__)."./app/Services/Services.php";

$user = new Services();

if($user->isSession()) {
    $data = [];
    if(!empty($user->getExercises())){
        $data = $user->getExercises();
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
    <script rel="preload" as="script" crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.min.js"></script>
    <title>Exercise Details</title>
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
    <?php include __DIR__."/header.php" ?>
    <div class="wrap__inner">
        <div class="wrap__title">
            <h1>Exercise Details</h1>
        </div>
        <div class="wrap__content">
            <div class="subject__list">
                <form class="exercise__details" action="" method="GET">
                <div class="col-12">
                    <input type="hidden" id="id" name="course_id" value="<?= $_SESSION['course_id']?>" class="form-control" placeholder="Id">
                    <table class="table table-bordered table-striped" style="margin-top:20px;">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Summary</th>
                            <th class="col-4">Content</th>
                            <th class="col-3">File Name</th>
                            <th class="col-2">Note</th>
                        </thead>
                        <tbody>
                        <?php
                            if (!empty($data)) {
                                foreach ($data as $row) {
                            ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['summary'] ?></td>
                                    <td><?= $row['content'] ?></td>
                                    <td><?= $row['file_name'] ?></td>
                                    <td>
                                        <a href='vote-exercise.php?exercise_id=<?=$row['_id']?>' class='btn btn-outline-danger btn-sm'>Vote</a>
                                        <a href='comment-exercises.php?exercise_id=<?=$row['id']?>' class='btn btn-outline-success btn-sm'>Comment</a>
                                    <?php if($user->role('teacher')){
                                    ?>
                                        <a href='teacher/download-exercises.php?path=<?= $row['file_name'] ?>' class='btn btn-outline-primary btn-sm'>Download</a>
                                    <?php 
                                        } 
                                    ?>
                                    </td>
                                </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
    <?php include __DIR__."/footer.php"?>
</body>
</html>