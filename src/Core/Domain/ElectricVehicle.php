<?php

declare(strict_types = 1);

namespace Example\App\Core\Domain;

class ElectricVehicle
{
    private Heading $heading;
    private Point $position;
    private Surface $surface;

    public function __construct(Surface $surface, Point $startingPoint, Heading $heading)
    {
        $this->surface = $surface;
        $this->surface->addElectricVheicle($this);
        $this->heading = $heading;
        $this->position = $startingPoint;
    }

    public function execute(string $command): string
    {
        foreach ($this->parseInstructions($command) as $instruction) {
            if ($instruction === 'L') {
                $this->heading = $this->heading->toLeft();
            }
            if ($instruction === 'R') {
                $this->heading = $this->heading->toRight();
            }
            if ($instruction === 'M') {
                $this->position = $this->moveForward();
            }
        }

        return $this->toString();
    }

    private function parseInstructions(string $command): array
    {
        return str_split($command, 1);
    }

    private function moveForward(): Point
    {
        $newPosition = $this->position;

        if ($this->heading->equals(Heading::NORTH())) {
            $newPosition = new Point($this->position->x(), $this->position->y() + 1);
        }

        if ($this->heading->equals(Heading::WEST())) {
            $newPosition = new Point($this->position->x() - 1, $this->position->y());
        }

        if ($this->heading->equals(Heading::SOUTH())) {
            $newPosition = new Point($this->position->x(), $this->position->y() - 1);
        }

        if ($this->heading->equals(Heading::EAST())) {
            $newPosition = new Point($this->position->x() + 1, $this->position->y());
        }

        if (!$this->surface->isDestinationWithinBounds($newPosition)) {
            throw new \OutOfBoundsException();
        }

        if ($this->surface->isPositionOccupiedByAnotherEV($newPosition)) {
            throw new CollissionError();
        }

        return $newPosition;
    }

    public function position(): Point
    {
        return $this->position;
    }

    public function heading(): Heading
    {
        return $this->heading;
    }

    private function toString(): string
    {
        return $this->position->toString() . ':' . $this->heading->toString();
    }
}
