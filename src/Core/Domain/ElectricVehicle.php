<?php

declare(strict_types = 1);

namespace Example\App\Core\Domain;

class ElectricVehicle
{
    private string $direction;
    private Point $position;
    private Surface $surface;

    public function __construct(Surface $surface, Point $startingPoint)
    {
        $this->surface = $surface;
        $this->surface->addElectricVheicle($this);
        $this->direction = 'N';
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
        if ($this->direction === 'N') {
            return new Point($this->position->x(), $this->position->y() + 1);
        }
        if ($this->direction === 'W') {
            return new Point($this->position->x() - 1, $this->position->y());
        }
        if ($this->direction === 'S') {
            return new Point($this->position->x(), $this->position->y() - 1);
        }
        if ($this->direction === 'E') {
            return new Point($this->position->x() + 1, $this->position->y());
        }

        return $this->position;
    }

    public function position()
    {
        return $this->position;
    }
}
