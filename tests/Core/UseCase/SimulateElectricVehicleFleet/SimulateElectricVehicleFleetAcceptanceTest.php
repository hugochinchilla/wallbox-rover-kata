<?php

declare(strict_types = 1);

namespace Example\Tests\Core\UseCase\SimulateElectricVehicleFleet;

use Example\App\Core\Domain\CollissionError;
use Example\App\Core\UseCase\SimulateElectricVehicleFleet\SimulateElectricVehicleFleet;
use Example\App\Core\UseCase\SimulateElectricVehicleFleet\StringFleetInput;
use Example\App\Core\UseCase\SimulateElectricVehicleFleet\StringFleetOutput;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Example\App\Core\UseCase\SimulateElectricVehicleFleet\SimulateElectricVehicleFleet
 */
class SimulateElectricVehicleFleetAcceptanceTest extends TestCase
{
    /** @test */
    public function read_surface_definition_and_single_ev(): void
    {
        $input = new StringFleetInput("5 5\n1 2 N\nLMLMLMLMM\n");
        $output = new StringFleetOutput();
        $simulator = new SimulateElectricVehicleFleet($input, $output);

        $simulator->execute();

        $this->assertEquals("1 3 N\n", $output->readValue());
    }

    /** @test */
    public function read_surface_definition_and_multiple_ev(): void
    {
        $input = new StringFleetInput("5 5\n1 2 N\nLMLMLMLMM\n3 3 E\nMMRMMRMRRM\n");
        $output = new StringFleetOutput();
        $simulator = new SimulateElectricVehicleFleet($input, $output);

        $simulator->execute();

        $this->assertEquals("1 3 N\n5 1 E\n", $output->readValue());
    }

    /** @test */
    public function handles_input_in_lowercase(): void
    {
        $input = new StringFleetInput("5 5\n1 2 n\nlmlmlmlmm\n");
        $output = new StringFleetOutput();
        $simulator = new SimulateElectricVehicleFleet($input, $output);

        $simulator->execute();

        $this->assertEquals("1 3 N\n", $output->readValue());
    }

    /** @test */
    public function throws_out_of_bonds_errors_when_crashing_with_surface_limits(): void
    {
        $input = new StringFleetInput("1 1\n1 2 N\nMM\n");
        $output = new StringFleetOutput();
        $simulator = new SimulateElectricVehicleFleet($input, $output);

        $this->expectException(\OutOfBoundsException::class);

        $simulator->execute();
    }

    /** @test */
    public function throw_collission_error_when_charshing_against_another_ev(): void
    {
        $input = new StringFleetInput("2 1\n2 1 N\nL\n1 1 E\nM\n");
        $output = new StringFleetOutput();
        $simulator = new SimulateElectricVehicleFleet($input, $output);

        $this->expectException(CollissionError::class);

        $simulator->execute();
    }

    /** @test */
    public function handle_input_with_vehicles_without_commands(): void
    {
        $input = new StringFleetInput("2 2\n1 1 N\n0 0 E\nM\n");
        $output = new StringFleetOutput();
        $simulator = new SimulateElectricVehicleFleet($input, $output);

        $simulator->execute();

        $this->assertEquals("1 1 N\n1 0 E\n", $output->readValue());
    }
}
