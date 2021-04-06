<?php

namespace Example\Tests\Core\Domain;

use Example\App\Core\Domain\ElectricVehicle;
use Example\App\Core\Domain\Surface;
use PHPUnit\Framework\TestCase;

class SurfaceTest extends TestCase
{
    /** @test */
    public function an_ev_can_move_inside_a_surface(): void
    {
        $surface = new Surface(10,10);
        $ev = new ElectricVehicle($surface);

        $ev->execute('M');

        $this->expectNotToPerformAssertions();
    }
}
