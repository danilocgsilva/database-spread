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

    /**
     * Exposes databaseName object property
     */
    public function getDatabaseName(): string
    {
        return $this->databaseName;
    }

    /**
     * Yields Generator providing
     *    Danilocgsilva\DatabaseSpread\DatabaseStructure\Table only setting
     *    name to the table.
     */
    public function getTables(): Generator
    {
        $query = "SELECT TABLE_NAME as name, TABLE_TYPE as table_type FROM information_schema.tables "
            . "WHERE table_schema = :table_schema;";
        $resource = $this->pdo->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $resource->execute([":table_schema" => $this->databaseName]);
        foreach ($resource->fetchAll(PDO::FETCH_NUM) as $row) {
            $table = (new Table())->setName($row[0]);
            if ($row[1] === "BASE TABLE") {
                $table->unsetIsView();
            } else {
                $table->setIsView();
            }
            yield $table;
        }
    }

    /**
     * Yields Generator providing 
     *    Danilocgsilva\DatabaseSpread\DatabaseStructure\Table setting table
     *    size
     */
    public function getTablesWithSizes(): Generator
    {
        $queryWithSizesBase = "SELECT TABLE_NAME as name, DATA_LENGTH + INDEX_LENGTH as size FROM information_schema.tables WHERE table_schema = :table_schema AND table_type = :base_table";
        $resource = $this->pdo->prepare($queryWithSizesBase, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $resource->execute([":table_schema" => $this->databaseName, ":base_table" => "BASE TABLE"]);
        foreach ($resource->fetchAll(PDO::FETCH_CLASS, Table::class) as $table) {
            yield $table;
        }
    }

    /**
     * Yields Danilocgsilva\DatabaseSpread\DatabaseStructure\Field;
     */
    public function getFields(string $table): Generator
    {
        $fieldsQuery = sprintf("DESCRIBE %s", $table);
        $resource = $this->pdo->query($fieldsQuery);
        foreach ($resource->fetchAll(PDO::FETCH_CLASS, Field::class) as $field) {
            yield $field;
        }
    }

    public function getTablesWithHeights(): Generator
    {
        foreach ($this->getTablesNotViews() as $table) {
            $this->hydrateHeight($table);
            yield $table;
        }
    }

    /**
     * Fills table with the height information (rows count)
     */
    public function hydrateHeight(Table $table): void
    {
        $query = "SELECT COUNT(*) as height FROM $table;";
        $resource = $this->pdo->prepare($query);
        $resource->execute();
        $table->setHeight(
            (int) ($resource->fetch())["height"]
        );
    }

    public function hydrateSize(Table $table): bool
    {
        if ($table->getIsView()) {
            return false;
        }
        
        $queryGetTableSize = "SELECT "
            . "TABLE_NAME as name, DATA_LENGTH + INDEX_LENGTH as size FROM information_schema.tables "
            . "WHERE table_schema = :table_schema AND TABLE_NAME = :table_name";
        $resource = $this->pdo->prepare($queryGetTableSize, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $resource->execute([":table_schema" => $this->databaseName, ":table_name" => $table->getName()]);
        $table->setSize(
            (int) ($resource->fetch())["size"]
        );
        return true;
    }

    public function hydrateIsView(Table $table)
    {
        $queryTableType = "SELECT TABLE_TYPE as table_type"
            . "FROM information_schema.tables "
            . "WHERE TABLE_SCHEMA = :database_name AND TABLE_NAME = :table_name;";
        $resource = $this->pdo->prepare($queryTableType,  [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $resource->execute([
            ':database_name' => $this->databaseName,
            ':table_name' => $table->getName()
        ]);

        $tableType = ($resource->fetch())["table_type"];

        match ($tableType) {
            "BASE TABLE" => $table->unsetIsView(),
            "VIEW" => $table->setIsView(),
            default => throw new Exception("The table is from an unknown type.")
        };
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * Filters only tables, excluding views. Yields
     *   Danilocgsilva\DatabaseSpread\DatabaseStructure\Table with its name
     */
    private function getTablesNotViews(): Generator
    {
        $queryWithSizesBase = "SELECT TABLE_NAME as name FROM information_schema.tables WHERE table_schema = :table_schema AND table_type = :base_table";
        $resource = $this->pdo->prepare($queryWithSizesBase, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $resource->execute([":table_schema" => $this->databaseName, ":base_table" => "BASE TABLE"]);
        foreach ($resource->fetchAll(PDO::FETCH_CLASS, Table::class) as $table) {
            yield $table;
        }
    }
}
