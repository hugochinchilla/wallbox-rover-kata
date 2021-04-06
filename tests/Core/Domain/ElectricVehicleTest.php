<?php

namespace Example\Tests\Core\Domain;

use Example\App\Core\Domain\ElectricVehicle;
use PHPUnit\Framework\TestCase;

class ElectricVehicleTest extends TestCase
{
    /**
     * @test
     */
    public function a_ev_should_rotate_left(): void
    {
        $ev = new ElectricVehicle();

        $result = $ev->execute('L');

        $this->assertEquals('0:0:W', $result);
    }
}
