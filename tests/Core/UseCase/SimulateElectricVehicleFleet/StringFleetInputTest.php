<?php

declare(strict_types = 1);

namespace Example\Tests\Core\UseCase\SimulateElectricVehicleFleet;

use Example\App\Core\Domain\InvalidHeadingError;
use Example\App\Core\UseCase\SimulateElectricVehicleFleet\StringFleetInput;
use PHPUnit\Framework\TestCase;

class StringFleetInputTest extends TestCase
{
    /** @test */
    public function invalid_heading_causes_input_error(): void
    {
        $this->expectException(InvalidHeadingError::class);

        new StringFleetInput("5 5\n0 0 X\nMM\n");
    }
}
