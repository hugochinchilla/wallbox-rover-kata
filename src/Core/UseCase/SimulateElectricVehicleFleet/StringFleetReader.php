<?php

declare(strict_types = 1);

namespace Example\App\Core\UseCase\SimulateElectricVehicleFleet;

use Example\App\Core\Domain\ElectricVehicle;
use Example\App\Core\Domain\Point;
use Example\App\Core\Domain\Surface;

class StringFleetReader implements FleetReader
{
    private array $lines = [];
    private Surface $surface;

    private array $commands;

    /**
     * @var ElectricVehicle[]
     */
    private array $fleet;

    public function __construct(string $input)
    {
        $this->lines = $this->splitLines($input);
        $this->readSurface();
        $this->readEvsAndCommands();
    }

    public function surface(): Surface
    {
        return $this->surface;
    }

    /**
     * @return ElectricVehicle[]
     */
    public function fleet(): array
    {
        return $this->fleet;
    }

    public function commandsForEv(ElectricVehicle $ev): string
    {
        return $this->commands[spl_object_hash($ev)];
    }

    private function splitLines(string $input): array
    {
        return explode("\n", $input);
    }

    private function readSurface(): void
    {
        $line = array_shift($this->lines);
        [$maxX, $maxY] = explode(' ', $line);

        $this->surface = new Surface((int) $maxX, (int) $maxY);
    }

    private function readEvsAndCommands(): void
    {
        $evInstructions = array_chunk(array_filter($this->lines), 2);

        foreach ($evInstructions as $instruction) {
            $ev = $this->parseEvLine($instruction[0]);
            $this->fleet[] = $ev;
            $this->addCommands($ev, $instruction[1]);
        }
    }

    private function parseEvLine(string $line)
    {
        [$x, $y, $direction] = explode(" ", $line);

        return new ElectricVehicle($this->surface, new Point((int) $x, (int) $y), $direction);
    }

    private function addCommands(ElectricVehicle $ev, string $commands)
    {
        $this->commands[spl_object_hash($ev)] = $commands;
    }
}
