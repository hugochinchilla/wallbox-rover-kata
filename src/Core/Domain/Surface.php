<?php

declare(strict_types = 1);

namespace Example\App\Core\Domain;

class Surface
{
    /**
     * @var ElectricVehicle[]
     */
    private array $vehicles = [];

    public function __construct(private int $maxX, private int $maxY)
    {
    }

    public function isDestinationWithinBounds(Point $point): bool
    {
        if ($point->x() > $this->maxX || $point->y() > $this->maxY) {
            return false;
        }

        if ($point->x() < 0 || $point->y() < 0) {
            return false;
        }

        return true;
    }

    public function isPositionOccupiedByAnotherEV(Point $point): bool
    {
        $obstacleCount = array_filter($this->vehicles, fn (ElectricVehicle $ev) => $ev->position()->equals($point));

        return count($obstacleCount) > 0;
    }


    public function addElectricVheicle(ElectricVehicle $ev): void
    {
        $this->vehicles[] = $ev;
    }
}
