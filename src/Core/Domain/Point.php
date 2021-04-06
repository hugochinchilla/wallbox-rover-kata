<?php

declare(strict_types = 1);

namespace Example\App\Core\Domain;

class Point
{
    public function __construct(private int $x, private int $y)
    {
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function toString(): string
    {
        return "{$this->x}:{$this->y}";
    }

    public function equals(Point $point): bool
    {
        return $point->x === $this->x && $point->y === $this->y;
    }
}
