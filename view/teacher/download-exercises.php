<?php
session_start();
include_once dirname(dirname(__DIR__))."./app/Services/TeacherServices.php";
if(isset($_GET['path'])){
     $teacher = new TeacherServices();
     $data = $teacher->downloadFile();
 }