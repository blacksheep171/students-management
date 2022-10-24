<?php

class Log {

    public static function logError($message){
        $logFile = dirname(__DIR__)."./my-errors.log";
        if(isset($message)){
            error_log($message."\n", 3, $logFile);
        } 
    }
}