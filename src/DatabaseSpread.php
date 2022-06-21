<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread;

use PDO;
use Generator;
use PDOException;
use Exception;

class DatabaseSpread
{
    private string $databaseName;
    
    public function __construct(
        private PDO $pdo
    ) {}

    public function setDatabaseName(string $databaseName): self
    {
        try {
            $this->pdo->query(sprintf("USE %s", $databaseName));
        } catch (PDOException) {
            throw new Exception("Possibli a connection aerror.");
        }
        $this->databaseName = $databaseName;
        return $this;
    }

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
