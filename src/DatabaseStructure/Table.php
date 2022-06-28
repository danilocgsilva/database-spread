<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread\DatabaseStructure;

class Table
{
    private string $name;

    private int $size;

    private int $height;
    
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
        return $this->size;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;
        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function __toString()
    {
        return $this->name;
    }
}
