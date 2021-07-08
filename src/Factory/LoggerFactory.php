<?php 
namespace App\Factory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerFactory {
    public static function create(){

        $log = new Logger('CLI Log');
        $log->pushHandler(new StreamHandler(__DIR__ . '/debug.log', Logger::DEBUG));
        return $log;
    }
}