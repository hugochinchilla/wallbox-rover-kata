<?php

namespace Example\App\Core\UseCase\SimulateElectricVehicleFleet;

use Example\App\Core\Domain\ElectricVehicle;
use Example\App\Core\Domain\Surface;

interface FleetReader
{
    public function surface(): Surface;

    /**
     * @return ElectricVehicle[]
     */
    public function fleet(): array;

    public function commandsForEv(ElectricVehicle $ev): string;
}