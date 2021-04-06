<?php

namespace Example\Tests\Core\Domain;

use Example\App\Core\Domain\ElectricVehicle;
use Example\App\Core\Domain\Point;
use Example\App\Core\Domain\Surface;
use PHPUnit\Framework\TestCase;

class SurfaceTest extends TestCase
{
    /** @test */
    public function a_surface_can_reveal_if_a_position_is_valid_to_move_into_it(): void
    {
        $surface = new Surface(10,10);

        $this->assertTrue($surface->isValidDestination(new Point(0, 0)));
    }

    /** @test */
    public function the_surface_boundaries_are_invalid_movements(): void
    {
        $surface = new Surface(10,10);

        $this->assertFalse($surface->isValidDestination(new Point(11, 10)));
        $this->assertFalse($surface->isValidDestination(new Point(10, 11)));
        $this->assertFalse($surface->isValidDestination(new Point(-1, 0)));
        $this->assertFalse($surface->isValidDestination(new Point(0, -1)));
    }

    /** @test */
    public function a_position_occupied_by_an_ev_is_not_a_valid_destination(): void
    {
        $surface = new Surface(10,10);
        new ElectricVehicle($surface);

        $this->assertFalse($surface->isValidDestination(new Point(0, 0)));
    }

    /** @test */
    public function the_surface_tracks_ev_movements(): void
    {
        $surface = new Surface(10,10);
        $ev = new ElectricVehicle($surface);
        $ev->execute('M');

        $this->assertTrue($surface->isValidDestination(new Point(0, 0)));
        $this->assertFalse($surface->isValidDestination(new Point(0, 1)));
    }
}
