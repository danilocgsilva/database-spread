<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread\DatabaseStructure;

class Field
{
    private string $Name;

    private string $Type;

    private string $Null;

    private string $Key;

    private string $Default;

    private string $Extra;

    public function getName(): string
    {
        return $this->Name;
    }

    public function getType(): string
    {
        return $this->Type;
    }

    public function getNull(): string
    {
        return $this->Null;
    }

    public function getKey(): string
    {
        return $this->Key;
    }

    public function getDefault(): string
    {
        return $this->Default;
    }

    public function getExtra(): string
    {
        return $this->Extra;
    }
}