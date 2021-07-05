<?php

namespace App\Config;

use Monolog\Logger;
use ErrorException;

class ConfigOptions {

    private Logger $logger;

    public function __construct(Logger $logger){
        $this->logger = $logger;
        $this->setup_errors();
    }

    private function setup_errors(){

        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            // error was suppressed with the @-operator
            if (0 === error_reporting()) {
                return false;
            }
    
            $this->logger->debug($errstr, [ 
                'Error Code' => $errno, 
                'Error File' => $errfile, 
                'Error Line' => $errline, 
                'User' => get_current_user() 
            ]);
    
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
        
    }
}