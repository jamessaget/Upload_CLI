<?php 
namespace App\Factory;
use App\Classes\ImageStorageCli;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Classes\LocalStorageDriver;
use App\Config\ConfigOptions;

class CliFactory {
    public static function create(string $option){

        // Setup Logger
        $log = new Logger('CLI Log');
        $log->pushHandler(new StreamHandler(__DIR__.'/debug.log', Logger::DEBUG));
        new ConfigOptions($log);

        // Setup LocalStorageDriver Class 
        $storage_driver = new LocalStorageDriver($log);

        return new ImageStorageCLI($storage_driver, $option);
    }
}