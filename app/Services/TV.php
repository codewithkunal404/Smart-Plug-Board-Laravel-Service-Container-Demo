<?php

namespace App\Services;

class TV implements PowerInterface
{
    public function ON()
    {
        return "📺 TV is playing your favorite show!";
    }
}