<?php

declare(strict_types = 1);

namespace Example\App\Core\UseCase\SimulateElectricVehicleFleet;

class SimulateElectricVehicleFleet
{
    public function __construct(private FleetReader $reader, private FleetOutput $output)
    {
    }

    public function execute(): string
    {
        $fleet = $this->reader->fleet();

        foreach ($fleet as $ev) {
            $ev->execute($this->reader->commandsForEv($ev));
        }

        return $this->output->reportFleetStatus($fleet);
    }
}
