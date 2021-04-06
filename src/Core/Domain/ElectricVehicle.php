<?php

declare(strict_types = 1);

namespace Example\App\Core\Domain;

class ElectricVehicle
{
    private string $direction;

    public function __construct()
    {
        $this->direction = "N";
    }

    public function execute(string $command): string
    {
        foreach ($this->parseInstructions($command) as $instruction) {
            if ($instruction === "L") {
                $this->direction = $this->rotateLeft();
            }
            if ($instruction === "R") {
                $this->direction = $this->rotateRight();
            }
        }

        return "0:0:" . $this->direction;
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
}
