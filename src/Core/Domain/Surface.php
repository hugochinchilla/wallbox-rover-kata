<?php

declare(strict_types = 1);

namespace Example\App\Core\Domain;

class Surface
{
    public function __construct(private int $width, private int $height)
    {
    }
}
