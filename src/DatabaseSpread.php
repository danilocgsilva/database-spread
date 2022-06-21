<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread;

use PDO;
use Generator;
use PDOException;
use Exception;
use Danilocgsilva\DatabaseSpread\DatabaseStructure\{Table, Field};

class DatabaseSpread implements MethodsInterface
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
        $queryWithSizesBase = "SELECT TABLE_NAME as name, DATA_LENGTH + INDEX_LENGTH as size FROM information_schema.tables WHERE table_schema = :table_schema";
        $resource = $this->pdo->prepare($queryWithSizesBase, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $resource->execute([":table_schema" => $this->databaseName]);
        foreach ($resource->fetchAll(PDO::FETCH_CLASS, Table::class) as $table) {
            yield $table;
        }
    }

    public function getFields(string $table): Generator
    {
        $fieldsQuery = sprintf("DESCRIBE :%s", $table);
        $resource = $this->pdo->query($fieldsQuery);
        foreach ($resource->fetchAll(PDO::FETCH_CLASS, Field::class) as $field) {
            yield $field;
        }
    }
}
