<?php

namespace Example\Tests\Core\UseCase;

use Example\App\Core\UseCase\SimulateElectricVehicleFleet\SimulateElectricVehicleFleet;
use Example\App\Core\UseCase\SimulateElectricVehicleFleet\StringFleetOutput;
use Example\App\Core\UseCase\SimulateElectricVehicleFleet\StringFleetReader;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Example\App\Core\UseCase\SimulateElectricVehicleFleet\SimulateElectricVehicleFleet
 */
class SimulateElectricVehicleFleetAcceptanceTest extends TestCase
{
    /** @test */
    public function read_surface_definition_and_single_ev(): void
    {
        $reader = new StringFleetReader("5 5\n1 2 N\nLMLMLMLMM\n");
        $output = new StringFleetOutput();
        $simulator = new SimulateElectricVehicleFleet($reader, $output);

        $output = $simulator->execute();

        $this->assertEquals("1 3 N\n", $output);
    }

    /** @test */
    public function read_surface_definition_and_multiple_ev(): void
    {
        $reader = new StringFleetReader("5 5\n1 2 N\nLMLMLMLMM\n3 3 E\nMMRMMRMRRM\n");
        $output = new StringFleetOutput();
        $simulator = new SimulateElectricVehicleFleet($reader, $output);

        $output = $simulator->execute();

        $this->assertEquals("1 3 N\n5 1 E\n", $output);
    }
}
