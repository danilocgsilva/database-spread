<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread;

use Generator;

interface MethodsInterface
{
    public function setDatabaseName(string $databaseName): self;

    public function getTables(): Generator;

    public function getTablesWithSizes(): Generator;

    public function getTablesWithHeights(): Generator;

    public function getFields(string $table): Generator;
}
