<?php 

namespace App\Services;
class SimpleService
{
    public $name;

    public function __construct(string $name){
        //$this->name = "TheoServicio";
        $this->name = $name;
    }
    public function getService(){
        return "Simple Service obtained successfully by ".$this->name;
    }
}