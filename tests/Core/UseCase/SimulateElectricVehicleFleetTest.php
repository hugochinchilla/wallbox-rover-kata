<?php

namespace Example\Tests\Core\UseCase;

use Example\App\Core\UseCase\SimulateElectricVehicleFleet;
use PHPUnit\Framework\TestCase;

class SimulateElectricVehicleFleetTest extends TestCase
{
    /** @test */
    public function read_surface_definition_and_single_ev(): void
    {
        $simulator = new SimulateElectricVehicleFleet();

        $output = $simulator->execute("5 5\n1 2 N\nLMLMLMLMM\n");

        $this->assertEquals("1 3 N\n", $output);
    }

    /** @test */
    public function read_surface_definition_and_multiple_ev(): void
    {
        $simulator = new SimulateElectricVehicleFleet();

        $output = $simulator->execute("5 5\n1 2 N\nLMLMLMLMM\n3 3 E\nMMRMMRMRRM\n");

        $this->assertEquals("1 3 N\n5 1 E\n", $output);
    }
}
