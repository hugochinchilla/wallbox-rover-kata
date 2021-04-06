<?php

declare(strict_types = 1);

namespace Example\App\Core\Domain;

class Surface
{
    public function __construct(private int $maxX, private int $maxY)
    {
    }

    public function isValidDestination(Point $point): bool
    {
        if ($point->x() > $this->maxX || $point->y() > $this->maxY) {
            return false;
        }

        if ($point->x() < 0 || $point->y() < 0) {
            return false;
        }

        return true;
    }
}
