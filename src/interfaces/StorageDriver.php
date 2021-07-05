<?php 

namespace App\Interfaces;

interface StorageDriver {

    public function storeImg(string $file, string $name);

    public function getImg(string $file);

    public function deleteImg(string $file);
    
}