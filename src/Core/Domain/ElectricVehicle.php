<?php

declare(strict_types = 1);

namespace Example\App\Core\Domain;

class ElectricVehicle
{
    private string $direction;

    public function __construct()
    {
        $this->direction = 'N';
        $this->position = new Point(0, 0);
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

        return $this->position;
    }
}
