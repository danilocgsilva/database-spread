<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread\DatabaseStructure;

class Field
{
    private string $name;

    private string $type;

    private string $null;

    private string $key;

    private string $default;

    private string $extra;

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getNull(): string
    {
        return $this->null;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getDefault(): string
    {
        return $this->default;
    }

    public function getExtra(): string
    {
        return $this->extra;
    }
}