<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread\DatabaseStructure;

class Table
{
    private string $name;

    private ?int $size;

    private int $height;

    private bool $isView;
    
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): ?int
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

    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function setIsView(): self
    {
        $this->isView = true;
        return $this;
    }

    public function unsetIsView(): self
    {
        return $this->isView = false;
        return $this;
    }

    public function getIsView(): bool
    {
        return $this->isView;
    }

    public function __toString()
    {
        return $this->name;
    }
}
