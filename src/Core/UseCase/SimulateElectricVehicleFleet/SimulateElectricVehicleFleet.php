<?php

declare(strict_types = 1);

namespace Example\App\Core\UseCase\SimulateElectricVehicleFleet;

class SimulateElectricVehicleFleet
{
    public function execute(FleetReader $reader): string
    {
        $outputs = [];

        foreach ($reader->fleet() as $ev) {
            $result = $ev->execute($reader->commandsForEv($ev));
            $outputs[] = str_replace(':', ' ', $result);
        }

        $outputs[] = '';

        return implode("\n", $outputs);
    }
}
