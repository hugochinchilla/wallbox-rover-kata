<?php

declare(strict_types = 1);

namespace Example\App\Core\UseCase\SimulateElectricVehicleFleet;

class SimulateElectricVehicleFleet
{
    public function __construct(private FleetInput $input, private FleetOutput $output)
    {
    }

    public function execute(): void
    {
        $fleet = $this->input->fleet();

        foreach ($fleet as $ev) {
            $ev->execute($this->input->commandsForEv($ev));
        }

        $this->output->loadFleetData($fleet);
    }
}
