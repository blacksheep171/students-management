<?php
session_start();
include_once  dirname(__DIR__,1)."./app/Services/ReportServices.php";

$user = new ReportServices();

    $data = $user->list();
    $submitSubject = $user->getMostSubmittedSubject();
    $ratingSubject = $user->getMostRatingSubject();
    $commentSubject = $user->getMostCommentsSubject();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Roboto&display=swap" rel="stylesheet">
    <script rel="preload" as="script" crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.min.js"></script>
    <title>Student Management</title>
</head>

<body>

    <div class="wrap wrap-fluid homepage">
        <?php include __DIR__."/header.php" ?>
        <div class="wrap__inner">
            <div class="wrap__title">
                <h1>Welcome to Homepage</h1>
            </div>
            <div class="wrap__content">
                <div class="subject__list d-flex flex-column align-items-center">
                <h3 class="h1-responsive font-weight-bold text-center my-4">SUBJECTS OF COURSE</h3>
                    <div class="col-10">
                        <table class="table table-bordered table-striped" style="margin-top:20px;">
                            <thead>
                                <th>ID</th>
                                <th>Course</th>
                                <th>Subject</th>
                                <th>Teacher</th>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($data)) {
                                    $index = 1;
                                    foreach ($data as $row) {
                                ?>
                                    <tr>
                                        <td><?= $index ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['title'] ?></td>
                                        <td><?= $user->getTeacherName($row['teacher_id']) ?></td>
                                    </tr>
                                <?php
                                    $index++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="wrap__content">
                <div class="subject__submit d-flex flex-column align-items-center">
                <h3 class="h1-responsive font-weight-bold text-center my-4">TOP RATING</h3>
                    <div class="col-7">
                        <table class="table table-bordered table-striped" style="margin-top:20px;">
                            <thead>
                                <th>Title</th>
                                <th>Subject</th>
                                <th>Teacher</th>
                                <th>Rating</th>
                                <th>Comments</th>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($submitSubject)) {
                                ?>
                                    <tr class="bg-warning">
                                        <td class="font-weight-bold">Most Submit</td>
                                        <td><?= $submitSubject['title'] ?></td>
                                        <td><?= $user->getTeacherName($submitSubject['teacher_id']) ?></td>
                                        <td><i id="like" class="fa fa-thumbs-up like-btn" data-id="<?= $submitSubject['id'] ?>"></i><?= $user->getCountLikesSubject($submitSubject['id']) ?></td>
                                        <td><?= $user->getCountSubmittedSubject($submitSubject['id']) ?></td>
                                    </tr>
                                <?php
                                }
                                if (!empty($ratingSubject)) {
                                ?>
                                    <tr class="bg-primary">
                                        <td class="font-weight-bold">Most Likes</td>
                                        <td><?= $ratingSubject['title'] ?></td>
                                        <td><?= $user->getTeacherName($ratingSubject['teacher_id']) ?></td>
                                        <td><i id="like" class="fa fa-thumbs-up like-btn" data-id="<?= $ratingSubject['id'] ?>"></i><?= $user->getCountLikesSubject($ratingSubject['id']) ?></td>
                                        <td><?= $user->getCountSubmittedSubject($ratingSubject['id'])?></td>
                                    </tr>
                                <?php
                                }
                                if (!empty($commentSubject)) {
                                ?>
                                    <tr  class="bg-success">
                                        <td class="font-weight-bold">Most Comments</td>
                                        <td><?= $commentSubject['title'] ?></td>
                                        <td><?= $user->getTeacherName($commentSubject['teacher_id']) ?></td>
                                        <td><i id="like" class="fa fa-thumbs-up like-btn" data-id="<?= $commentSubject['id'] ?>"></i><?= $user->getCountLikesSubject($commentSubject['id']) ?></td>
                                        <td><?= $commentSubject['total_comment'] ?></td>
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
    <?php include __DIR__."/footer.php" ?>
</body>

</html>
