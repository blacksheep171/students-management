<?php
require_once "./app/Config.php";

class Comments {
    private $table = 'comments';

    public $id;
    public $content;
    public $createdAt;
    public $updatedAt;
}