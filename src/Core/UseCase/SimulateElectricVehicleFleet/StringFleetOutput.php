<?php

declare(strict_types = 1);

namespace Example\App\Core\UseCase\SimulateElectricVehicleFleet;

use Example\App\Core\Domain\ElectricVehicle;

class StringFleetOutput implements FleetOutput
{
    /**
     * @param ElectricVehicle[] $fleet
     * @return string
     */
    public function reportFleetStatus(array $fleet): string
    {
        $outputs = [];

        foreach ($fleet as $ev) {
            $outputs[] = "{$ev->position()->x()} {$ev->position()->y()} {$ev->heading()->toString()}";
        }

        // adds a trailing newline to the generated output
        $outputs[] = '';

        return implode("\n", $outputs);
    }
}
