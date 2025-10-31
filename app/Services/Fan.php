<?php

namespace App\Services;

class Fan implements PowerInterface
{
    public function ON()
    {
           return "🌀 Fan is spinning!";
    }
}