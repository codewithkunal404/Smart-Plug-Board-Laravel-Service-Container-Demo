<?php

namespace App\Http\Controllers;

use App\Services\PowerInterface;
use Illuminate\Http\Request;

class PowerController extends Controller
{

    protected $power;
    public function __construct(PowerInterface $power){
        $this->power=$power;
    }


    public function showView(){
        $message=$this->power->ON();
        return view('power',compact('message'));
    }
}
