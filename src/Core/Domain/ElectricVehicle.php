<?php

declare(strict_types = 1);

namespace Example\App\Core\Domain;

class ElectricVehicle
{
    public function execute(string $string): string
    {
        return "0:0:W";
    }
}
