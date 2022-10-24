
<?php
session_start();
include_once dirname(__DIR__)."./app/Services/Services.php";

$user = new Services();

if($user->loggedIn()) {
    $permission = $user->permission();
    $data = [];
    if(!empty($user->getCommentList())){
        $data = $user->getCommentList();
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
    <title>Subject List</title>
</head>
<body>

<div class="wrap wrap-fluid exercise">
    <?php include __DIR__."/header.php" ?>
    <div class="wrap__inner exercise__comment">
        <div class="wrap__title">
            <h1>My Subject List</h1>
        </div>
        <div class="wrap__content">
            <div class="subject__list">
            <div class="col-3">
                <a id="add_comment" href='create-comments.php?exercise_id=<?=$user->getCurrentParams('exercise_id')?>' class='btn btn-primary btn-sm'>Add Comments</a>
            </div>
            <div class="col-12">
            <input type="hidden" id="id" name="id" value="<?= $course['id']?>" class="form-control" placeholder="Id">
            <table class="table table-bordered table-striped" style="margin-top:20px;">
                <thead>
                    <th>Username</th>
                    <th>Content</th>
                    <th>Date</th>
                </thead>
                <tbody>
                <?php
                    if (!empty($data)) {
                        foreach ($data as $row) {
                    ?>
                        <tr>
                            <td><?= $row['user_name'] ?></td>
                            <td><?= $row['content'] ?></td>
                            <td><?= $row['created_at'] ?></td>
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
    <?php include __DIR__."/footer.php"?>
</body>
</html>
<script>
    $(document).ready(function() {
    var courseStatus = <?= $permission?>;
    $('#add_comment').click(function(e) {
        if(courseStatus == 0) {
            e.preventDefault();
            alert("You don't have permission.");
        }
    });
});
</script>
