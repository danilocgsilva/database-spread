<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread;

class Table
{
    private string $name;
    
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
