<?php
session_start();
include_once dirname(__DIR__,2)."./app/Services/TeacherServices.php";
if(isset($_GET['path'])){
     $teacher = new TeacherServices();
     $data = $teacher->downloadFile();
 }