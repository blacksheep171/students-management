<?php

class Config {

    public static function connect() {
        
        $host = "127.0.0.1";
        $username = 'root';
        $password = '';
        $dbname = 'hsm';
       
        try {
            $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
        }
            return $con;
    }
}
?>