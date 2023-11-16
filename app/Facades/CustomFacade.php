<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;
class CustomFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'custom-service';
    }
}