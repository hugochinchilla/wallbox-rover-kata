<?php

declare(strict_types = 1);

namespace Example\App\Core\UseCase\SimulateElectricVehicleFleet;

use Example\App\Core\Domain\ElectricVehicle;
use Example\App\Core\Domain\Heading;
use Example\App\Core\Domain\InvalidHeadingError;
use Example\App\Core\Domain\Point;
use Example\App\Core\Domain\Surface;

class StringFleetInput implements FleetInput
{
    private array $lines;
    private Surface $surface;
    private array $commands;

    /**
     * @var ElectricVehicle[]
     */
    private array $fleet;

    public function __construct(string $input)
    {
        $this->lines = $this->splitLines(mb_strtoupper($input));
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
        $evKey = spl_object_hash($ev);

        if (!isset($this->commands[$evKey])) {
            return '';
        }

        return $this->commands[$evKey];
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
        $nonEmptyLines = array_filter($this->lines);
        $ev = null;
        foreach ($nonEmptyLines as $line) {
            if ($this->isStartingPositionLine($line)) {
                $ev = $this->parseEvLine($line);
                $this->fleet[] = $ev;
            } else {
                if ($ev) {
                    $this->addCommands($ev, $line);
                }
            }
        }
    }

    private function parseEvLine(string $line): ElectricVehicle
    {
        [$x, $y, $heading] = explode(' ', $line);

        return new ElectricVehicle(
            $this->surface,
            new Point((int) $x, (int) $y),
            $this->headingFromChar($heading),
        );
    }

    private function addCommands(ElectricVehicle $ev, string $commands): void
    {
        $this->commands[spl_object_hash($ev)] = $commands;
    }

    private function isStartingPositionLine(string $line): bool
    {
        return preg_match('/^\d+ \d+ \w$/', $line) === 1;
    }

    private function headingFromChar(string $char): Heading
    {
        switch ($char) {
            case 'N':
                return Heading::NORTH();
            case 'E':
                return Heading::EAST();
            case 'S':
                return Heading::SOUTH();
            case 'W':
                return Heading::WEST();
            default:
                throw new InvalidHeadingError();
        }
    }
}
