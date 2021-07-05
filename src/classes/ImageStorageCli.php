<?php

namespace App\Classes;

use ErrorException;
use App\Interfaces\StorageDriver;

class ImageStorageCli {

    private $image_input;

    private $image_name;

    private $image;

    private $retrieval = false;

    private $accepted_types = [
        '2' => '.jpeg', /*'IMAGETYPE_JPEG'*/ 
        '3' => '.png', /* 'IMAGETYPE_PNG' */
    ];

    private $methods = [
        'add' => [
            'method' => 'storeImg',
            'message' => 'Please enter an image path to be stored',
            'retrieval' => false
        ],
        'get' => [
            'method' => 'getImg',
            'message' => 'Please enter an image path to be stored',
            'retrieval' => true
        ],
        'remove' => [
            'method' => 'deleteImg',
            'message' => 'Please enter an image filename to be deleted',
            'retrieval' => true
        ]
    ];

    public function __construct(
        private StorageDriver $storage_driver,
        private string $option,
    ) {
        $this->cliInitialize();
    }

    private function cliInitialize(){
        try {
            $action = $this->methods[$this->option]['method'] ?? '';
            if($action && is_callable(array($this, $action))){
                $this->retrieval = $this->methods[$this->option]['retrieval'];
                $this->imageRead($this->methods[$this->option]['message']);
                $this->$action();
            }
        } catch (\Exception $ex ){
            if(str_contains($ex->getMessage(), 'errno=21') || str_contains(strtolower($ex->getMessage()), 'no such file or directory')){
                echo "\e[0;31mUnable to locate image, please review the provided path \e[0m\n";
            } else {
                echo $ex->getMessage();
            }
        }
    }

    private function imageRead(string $message){
        echo $message . PHP_EOL;
        $handle = fopen ("php://stdin", "r");
        $line = fgets($handle);

        $this->retrieval ? $this->cliValidation('./storage/' . $line) : $this->cliValidation($line);
        $image_file = file_get_contents($this->image_input);
        if($image_file === FALSE) throw new ErrorException("\e[0;31mUnable to locate image, please review the provided path or filename " . $this->image_input . "\e[0m\n");
        $this->image = $image_file;
        $this->getImageName();
    }

    private function cliValidation(string $image){
        $image_type = exif_imagetype(trim($image));
        if(!$image_type || !in_array($image_type, array_keys($this->accepted_types))){
            throw new ErrorException("\e[0;31mFile provided is not an accepted image type please review filetype " . $image . "\e[0m\n");
        } 
        $this->image_type = $this->accepted_types[$image_type];
        $this->image_input = trim($image);
    }

    private function getImageName(){
        if($this->retrieval) { 
            $this->image_name = $this->image_input;
        } else {
           $this->image_name = basename($this->image_input, ".php");
        }
    }
    
    private function storeImg(){
        $this->storage_driver->storeImg($this->image, $this->image_name);
    }

    public function getImg(){
        $this->storage_driver->getImg($this->image);
    }

    public function deleteImg(){
        $this->storage_driver->deleteImg($this->image_input);
    }

}