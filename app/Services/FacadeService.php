<?php
namespace App\Services;
class FacadeService
{
    public $name;

    public function __construct(string $name){
        //$this->name = "TheoServicio";
        $this->name = $name;
    }
    public function getService(){
        return "Facade Service obtained successfully by ".$this->name;
    }
}