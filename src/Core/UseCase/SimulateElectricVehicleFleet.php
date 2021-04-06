<?php

declare(strict_types = 1);

namespace Example\App\Core\UseCase;

use Example\App\Core\Domain\ElectricVehicle;
use Example\App\Core\Domain\Point;
use Example\App\Core\Domain\Surface;

class SimulateElectricVehicleFleet
{
    public function execute(string $input): string
    {
        $lines = $this->splitLines($input);
        $surface = $this->createSurface(array_shift($lines));
        $outputs = $this->createEvs($lines, $surface);

        return implode("\n", iterator_to_array($outputs));
    }

    private function splitLines(string $input): array
    {
        return explode("\n", $input);
    }


    private function createSurface(string $line): Surface
    {
        [$maxX, $maxY] = explode(' ', $line);

        return new Surface((int) $maxX, (int) $maxY);
    }

    private function createEvs(array $lines, Surface $surface): \Generator
    {
        $evInstructions = array_chunk(array_filter($lines), 2);

        foreach ($evInstructions as $instruction) {
            [$x, $y, $direction] = explode(" ", $instruction[0]);
            $ev = new ElectricVehicle($surface, new Point((int) $x, (int) $y), $direction);
            yield str_replace(':', ' ', $ev->execute($instruction[1]));
        }

        yield '';
    }
}
