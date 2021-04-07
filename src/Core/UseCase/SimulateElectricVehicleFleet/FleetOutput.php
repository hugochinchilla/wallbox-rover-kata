<?php

declare(strict_types = 1);

namespace Example\App\Core\UseCase\SimulateElectricVehicleFleet;

use Example\App\Core\Domain\ElectricVehicle;

interface FleetOutput
{
    /**
     * @param ElectricVehicle[] $fleet
     */
    public function loadFleetData(array $fleet): void;
}
