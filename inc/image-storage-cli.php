
<?php

// Image storage
// Image is provided/injected
//  PS3 compliant logger

class ImageStorageCLI {

    private $image_input;
    private $image_name;
    private $retrieval = false;
    private $image;
    private $image_type;
    private $accepted_types = [
        /*'IMAGETYPE_PNG'*/ 
        '2' => '.png',
        /* 'IMAGETYPE_JPEG' */
        '3' => '.jpeg',
    ];

    public function __construct(
        private StorageDriver $storage_driver,
        private string $option
    ) {
        $this->cli_initialize();
    }

    private function cli_initialize(){
        // REFACTOR IF ELSE
        // depending on $option passed define message
        try {
            if($this->option == 'add'){
                $this->image_read("Please enter an image path to be stored");
                $this->store_img();
            } else if($this->option == 'get'){
                $this->retrieval = true;
                $this->image_read("Please enter an image filename to be retreived");
                $this->get_img();
            } else if($this->option == 'remove'){
                $this->retrieval = true;
                $this->image_read("Please enter an image filename to be deleted");
                $this->delete_img();
            }
        } catch (\Exception $ex ){
            if(str_contains($ex->getMessage(), 'errno=21') || str_contains(strtolower($ex->getMessage()), 'no such file or directory')){
                echo "\e[0;31mUnable to locate image, please review the provided path \e[0m\n";
            } else {
                echo $ex->getMessage();
            }
        }
    }

    private function image_read($message){
        // "Please enter an image path to be uploaded"
        echo $message . PHP_EOL;
        $handle = fopen ("php://stdin","r");
        $line = fgets($handle);
        $this->cli_validation($line);

        // POTENTIAL REFACTOR VALIDATING DRY
        if($this->retrieval) {
            $image_file = file_get_contents('./storage/ ' . $this->image_input);
            if($image_file === FALSE) throw new ErrorException("\e[0;31mUnable to locate image, please review the provided filename " . $this->image_input . "\e[0m\n");
            $this->image = $image_file;
        } else {
            $image_file = file_get_contents($this->image_input);
            if($image_file === FALSE) throw new ErrorException("\e[0;31mUnable to locate image, please review the provided path " . $this->image_input . "\e[0m\n");
            $this->image = $image_file;
        }
        $this->get_image_name();
    }

    private function get_image_name(){
        if($this->retrieval) { 
            $this->image_name = $this->image_input;
        } else {
           $this->image_name = basename($this->image_input, ".php");
        }
    }

    private function cli_validation($image){

        $image_type = exif_imagetype(trim($image));
        if(!$image_type || !in_array($image_type, array_keys($this->accepted_types))){
            throw new ErrorException("\e[0;31mFile provided is not an accepted image type please review filetype " . $image . "\e[0m\n");
        } 
        $this->image_type = $this->accepted_types[$image_type];
        $this->image_input = trim($image);
    }

    // temporary testing function
    public function get_img_path(){
        echo $this->img_input;
    }

    private function store_img(){
        $this->storage_driver->store_img($this->image, $this->image_type, $this->image_name);
    }

    public function get_img(){
        $this->storage_driver->get_img($this->image);
    }

    public function delete_img(){
        $this->storage_driver->delete_img($this->image);
    }

}

// swap out FS storage for S3 BUCKET
interface StorageMethod {

}