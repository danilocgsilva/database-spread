<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread;

use PDO;
use Generator;

class DatabaseSpread
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function getTables(): Generator
    {
        $resource = $this->pdo->query("SHOW TABLES");
        foreach ($resource->fetchAll(PDO::FETCH_NUM) as $row) {
            yield (new Table())->setName($row[0]);
        }
    }

    public function getTablesWithSizes(): Generator
    {
        $queryWithSizes = sprintf("SELECT TABLE_NAME as name, DATA_LENGTH + INDEX_LENGTH as size FROM information_schema.tables WHERE table_schema = %s", );
        $resource = $this->pdo->query($queryWithSizes);
        foreach ($resource->fetchAll(PDO::FETCH_CLASS, Table::class) as $table) {
            yield $table;
        }
    }
}
