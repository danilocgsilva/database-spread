<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread\DatabaseStructure;

use Exception;

class Table
{
    private string $name;

    private ?int $size;

    private int $height;

    private bool $isView;
    
    /**
     * Set table's name
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * The table's name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get table size in bytes.
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * Set the table row count.
     */
    public function setHeight(int $height): self
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Get the table row count.
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * Size in bytes.
     */
    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Set the class to be a view, thus the size count does not
     *   applies.
     */
    public function setIsView(): self
    {
        $this->isView = true;
        return $this;
    }

    /**
     * Set the class to not be an view, so it's a real table
     */
    public function unsetIsView(): self
    {
        $this->isView = false;
        return $this;
    }

    public function getIsView(): bool
    {
        if (isset($this->isView)) {
            return $this->isView;
        }
        throw new Exception("This class has not received the data that says that is a view or a normal table.");
    }

    public function __toString()
    {
        return $this->name;
    }
}
