<?php 
namespace App\Factory;
use App\Classes\ImageStorageCli;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Classes\LocalStorageDriver;
use App\Config\ConfigOptions;
use ErrorException;

class CliFactory {
    public static function create(string $storage_driver, string $option){

        // Setup Logger
        $log = new Logger('CLI Log');
        $log->pushHandler(new StreamHandler(__DIR__ . '/debug.log', Logger::DEBUG));
        new ConfigOptions($log);

        try {
            switch($storage_driver) {
                case 'local': 
                    $storage_driver = new LocalStorageDriver($log);
                    break;
                default:
                    throw new ErrorException("\e[0;31mStorage driver not found\e[0m\n");
            }    
        } catch(\Exception $ex){
            echo $ex->getMessage();
        }

        return new ImageStorageCLI($storage_driver, $option);
    }
}