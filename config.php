<?php

function set_error_handling($logger){
    // Increase error sensitivity (mainly to capture non-existant folder warnings)
    set_error_handler(function($errno, $errstr, $errfile, $errline) use($logger) {
        // error was suppressed with the @-operator
        if (0 === error_reporting()) {
            return false;
        }

        $logger->debug($errstr, [ 
            'Error Code' => $errno, 
            'Error File' => $errfile, 
            'Error Line' => $errline, 
            'User' => get_current_user() 
        ]);

        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    });
}