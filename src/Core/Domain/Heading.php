<?php

declare(strict_types = 1);

namespace Example\App\Core\Domain;

class Heading
{
    private function __construct(private string $value)
    {
    }

    public function equals(Heading $other): bool
    {
        return $this->value === $other->value;
    }

    public static function NORTH(): self
    {
        return new self('N');
    }

    public static function EAST(): self
    {
        return new self('E');
    }

    public static function SOUTH(): self
    {
        return new self('S');
    }

    public static function WEST(): self
    {
        return new self('W');
    }

    public function toLeft(): self
    {
        if ($this->equals(self::NORTH())) {
            return self::WEST();
        }

        if ($this->equals(self::WEST())) {
            return self::SOUTH();
        }

        if ($this->equals(self::SOUTH())) {
            return self::EAST();
        }

        if ($this->equals(self::EAST())) {
            return self::NORTH();
        }
    }

    public function toRight(): self
    {
        if ($this->equals(self::NORTH())) {
            return self::EAST();
        }

        if ($this->equals(self::EAST())) {
            return self::SOUTH();
        }

        if ($this->equals(self::SOUTH())) {
            return self::WEST();
        }

        if ($this->equals(self::WEST())) {
            return self::NORTH();
        }
    }

    public function toString(): string
    {
        return $this->value;
    }
}
