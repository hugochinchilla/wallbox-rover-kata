<?php

declare(strict_types = 1);

namespace Example\App\Core\UseCase\SimulateElectricVehicleFleet;

use Example\App\Core\Domain\ElectricVehicle;
use Example\App\Core\Domain\Surface;

interface FleetInput
{
    public function surface(): Surface;

    /**
     * @return ElectricVehicle[]
     */
    public function fleet(): array;

    public function commandsForEv(ElectricVehicle $ev): string;
}
