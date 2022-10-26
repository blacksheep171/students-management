<?php
session_start();
include_once dirname(__DIR__,2)."./app/Services/PresidentServices.php";

$id = $_REQUEST['id'];

$president = new PresidentServices();
if($president->role('president')) {
    $data = $president->getCourses();
    if($data['status'] == 0){
        $update = $president->changeStatus(1);
    ?>
        <button type="button" onclick="changeStatus(<?=$id?>)" class="btn btn-success">Enable</button>
     <?php
    } else if($data['status'] == 1){
        $update = $president->changeStatus(0);
    ?>
        <button type="button" onclick="changeStatus(<?=$id?>)" class="btn btn-danger">Disable</button>
    <?php
    }
}
?>