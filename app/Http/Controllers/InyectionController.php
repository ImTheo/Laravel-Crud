<?php

namespace App\Http\Controllers;

use App\Facades\CustomFacade;
use App\Services\SimpleService;
use Illuminate\Http\Request;

class InyectionController extends Controller
{
    public function getService(SimpleService $simpleService){
        return $simpleService->getService();
    }

    public function getServiceFacade(){
        return CustomFacade::getService();
    }
}
