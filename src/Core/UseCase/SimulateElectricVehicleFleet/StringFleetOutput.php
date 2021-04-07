<?php

declare(strict_types = 1);

namespace Example\App\Core\UseCase\SimulateElectricVehicleFleet;

use Example\App\Core\Domain\ElectricVehicle;

class StringFleetOutput implements FleetOutput
{
    private string $output = '';

    /**
     * @param ElectricVehicle[] $fleet
     */
    public function loadFleetData(array $fleet): void
    {
        $outputs = [];

        foreach ($fleet as $ev) {
            $outputs[] = "{$ev->position()->x()} {$ev->position()->y()} {$ev->heading()->toString()}";
        }

        // adds a trailing newline to the generated output
        $outputs[] = '';

        $this->output = implode("\n", $outputs);
    }

    public function readValue(): string
    {
        return $this->output;
    }
}
