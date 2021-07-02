
<?php

// Image storage
// Image is provided/injected
//  PS3 compliant logger

class ImageStorageCLI {

    private $img_path;
    private $image;
    private $accepted_types = [
        /*'IMAGETYPE_PNG'*/ 
        '2',
        /* 'IMAGETYPE_JPEG' */
        '3',
    ];

    public function __construct() {
        $this->cli_initialize();
        $this->store_img();
    }

    private function cli_initialize(){

        echo "Please enter an image path to be uploaded" . PHP_EOL;
        $handle = fopen ("php://stdin","r");
        $line = fgets($handle);

        try {
            $this->cli_validation($line);
            $image_file = file_get_contents($this->img_path);
            if($image_file === FALSE) throw new ErrorException("\e[0;31mUnable to locate image, please review the provided path " . $this->img_path . "\e[0m\n");
            $this->image = $image_file;
        } catch (\Exception $ex ){
            if(str_contains($ex->getMessage(), 'errno=21') || str_contains(strtolower($ex->getMessage()), 'no such file or directory')){
                echo "\e[0;31mUnable to locate image, please review the provided path \e[0m\n";
            } else {
                echo $ex->getMessage();
            }
        }
    }

    private function cli_validation($image_path){

        $image_type = exif_imagetype(trim($image_path));
        if(!$image_type || !in_array($image_type, $this->accepted_types)){
            throw new ErrorException("\e[0;31mFile provided is not an accepted image type please review filetype " . $image_path . "\e[0m\n");
        } 
        $this->img_path = trim($image_path);
    }

    // temporary testing function
    public function get_img_path(){
        echo $this->img_path;
    }

    private function store_img(){
        // store image locally 
    }

    public function get_img(){
        echo $this->image;
        // get user to enter image name
        // find image in storage and return on commandline
        // feedback to user
    }

    public function delete_img(){
        // get user to enter image name
        // call get_img
        // delete image file
        // feedback to user
    }

}

// swap out FS storage for S3 BUCKET
interface StorageMethod {

}