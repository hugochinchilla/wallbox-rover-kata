<?php

namespace Example\App\Core\UseCase\SimulateElectricVehicleFleet;

use Example\App\Core\Domain\ElectricVehicle;

interface FleetOutput
{
    /**
     * @param ElectricVehicle[] $fleet
     * @return string
     */
    public function reportFleetStatus(array $fleet): string;
}
