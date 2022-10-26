<?php
session_start();
include_once dirname(__DIR__,2)."./app/Services/PresidentServices.php";

$id = $_REQUEST['id'];

$president = new PresidentServices();
if($president->role('president')) {
    $data = $president->getCourses();
    if($data['status'] == 0){
        $update = $president->changeStatus(1);
    } else if($data['status'] == 1){
        $update = $president->changeStatus(0);
    }
    $course = $president->getCourses();
    $status = ($course['status'] == 1) ? "Enable" : "Disable";
    $result = [
        'id' => $course['id'],
        'name' => $course['name'],
        'status' => $course['status'],
        'action' => $status,
        'created_by' => $course['created_by'],
        'created_at' => $course['created_at'],
        'updated_at' => $course['updated_at']
    ];
    echo  json_encode($result);
}
?>