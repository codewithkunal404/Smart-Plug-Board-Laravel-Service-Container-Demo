<?php

namespace App\Services;

class Light implements PowerInterface
{
    public function ON()
    {
          return "💡 Light is shining!";
    }
}