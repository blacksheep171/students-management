<?php
require_once dirname(__DIR__)."./Config.php";

class Comments {
    private $table = 'comments';

    public $id;
    public $content;
    public $createdAt;
    public $updatedAt;
}