<?php

declare(strict_types = 1);

namespace Example\App\Core\Domain;

class ElectricVehicle
{
    private string $direction;
    private Point $position;
    private Surface $surface;

    public function __construct(Surface $surface, Point $startingPoint, string $direction)
    {
        $this->surface = $surface;
        $this->surface->addElectricVheicle($this);
        $this->direction = $direction;
        $this->position = $startingPoint;
    }

    public function execute(string $command): string
    {
        foreach ($this->parseInstructions($command) as $instruction) {
            if ($instruction === 'L') {
                $this->direction = $this->rotateLeft();
            }
            if ($instruction === 'R') {
                $this->direction = $this->rotateRight();
            }
            if ($instruction === 'M') {
                $this->position = $this->moveForward();
            }
        }

        return $this->position->toString() . ':' . $this->direction;
    }

    private function parseInstructions(string $command): array
    {
        return str_split($command, 1);
    }

    private function rotateLeft(): string
    {
        return [
            'N' => 'W',
            'W' => 'S',
            'S' => 'E',
            'E' => 'N',
        ][$this->direction];
    }

    private function rotateRight()
    {
        return [
            'N' => 'E',
            'E' => 'S',
            'S' => 'W',
            'W' => 'N',
        ][$this->direction];
    }

    private function moveForward()
    {
        $newPosition = $this->position;

        if ($this->direction === 'N') {
            $newPosition = new Point($this->position->x(), $this->position->y() + 1);
        }

        if ($this->direction === 'W') {
            $newPosition = new Point($this->position->x() - 1, $this->position->y());
        }

        if ($this->direction === 'S') {
            $newPosition = new Point($this->position->x(), $this->position->y() - 1);
        }

        if ($this->direction === 'E') {
            $newPosition = new Point($this->position->x() + 1, $this->position->y());
        }

        if (!$this->surface->isValidDestination($newPosition)) {
            throw new \OutOfBoundsException();
        }

        return $newPosition;
    }

    public function position()
    {
        return $this->position;
    }
}
