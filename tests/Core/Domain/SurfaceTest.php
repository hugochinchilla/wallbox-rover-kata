<?php

declare(strict_types = 1);

namespace Example\Tests\Core\Domain;

use Example\App\Core\Domain\ElectricVehicle;
use Example\App\Core\Domain\Heading;
use Example\App\Core\Domain\Point;
use Example\App\Core\Domain\Surface;
use PHPUnit\Framework\TestCase;

class SurfaceTest extends TestCase
{
    /** @test */
    public function a_surface_can_reveal_if_a_position_is_valid_to_move_into_it(): void
    {
        $surface = new Surface(10, 10);

        $this->assertTrue($surface->isDestinationWithinBounds(new Point(0, 0)));
    }

    /** @test */
    public function the_surface_boundaries_are_invalid_movements(): void
    {
        $surface = new Surface(10, 10);

        $this->assertFalse($surface->isDestinationWithinBounds(new Point(11, 10)));
        $this->assertFalse($surface->isDestinationWithinBounds(new Point(10, 11)));
        $this->assertFalse($surface->isDestinationWithinBounds(new Point(-1, 0)));
        $this->assertFalse($surface->isDestinationWithinBounds(new Point(0, -1)));
    }

    /** @test */
    public function a_position_can_be_checked_for_presence_of_another_ev(): void
    {
        $surface = new Surface(10, 10);
        new ElectricVehicle($surface, new Point(0, 0), Heading::NORTH());

        $this->assertTrue($surface->isPositionOccupiedByAnotherEV(new Point(0, 0)));
    }

    /** @test */
    public function the_surface_tracks_ev_movements(): void
    {
        $surface = new Surface(10, 10);
        $ev = new ElectricVehicle($surface, new Point(0, 0), Heading::NORTH());
        $ev->execute('M');

        $this->assertFalse($surface->isPositionOccupiedByAnotherEV(new Point(0, 0)));
        $this->assertTrue($surface->isPositionOccupiedByAnotherEV(new Point(0, 1)));
    }
}
