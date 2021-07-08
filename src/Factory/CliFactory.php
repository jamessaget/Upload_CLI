<?php 
namespace App\Factory;
use App\Classes\ImageStorageCli;
use Monolog\Logger;
use App\Classes\LocalStorageDriver;
use ErrorException;

class CliFactory {
    public static function create(string $storage_driver, string $option, Logger $log){

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