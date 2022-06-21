<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread;

class Table
{
    private string $name;

    private int $size;
    
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return 0;
    }

    public function __toString()
    {
        return $this->name;
    }
}
