<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread;

use Generator;
use PDO;
use Exception;
use PDOException;
use Danilocgsilva\DatabaseSpread\DatabaseStructure\Table;

class Main implements MethodsInterface
{
    private DatabaseSpread $databaseSpread;

    private string $databaseName;

    public function __construct(
        private PDO $pdo
    ) {
        $this->databaseSpread = new DatabaseSpread($pdo);
    }

    public function setDatabaseName(string $databaseName): self
    {
        $this->databaseSpread->setDatabaseName($databaseName);
        return $this;
    }

    public function getDatabaseName(): string
    {
        return $this->databaseSpread->getDatabaseName();
    }
    
    public function getTables(): Generator
    {
        try {
            yield from $this->databaseSpread->getTables();
        } catch (PDOException) {
            throw new Exception("Possibily a connection error.");
        }
    }

    public function getTablesWithSizes(): Generator
    {
        try {
            yield from $this->databaseSpread->getTablesWithSizes();
        } catch (PDOException) {
            throw new Exception("Possibily a connection error.");
        }
    }

    public function getFields(string $table): Generator
    {
        try {
            yield from $this->databaseSpread->getFields($table);
        } catch (PDOException) {
            throw new Exception("Possibily a connection error.");
        }
    }

    public function getTablesWithHeights(): Generator
    {
        try {
            yield from $this->databaseSpread->getTablesWithHeights();
        } catch (PDOException) {
            throw new Exception("Possibily a connection error.");
        }
    }

    /**
     * Fills the table size property.
     */
    public function hydrateSize(Table $table): void
    {
        $this->databaseSpread->hydrateSize($table);
    }

    /**
     * Fills the table height property.
     */
    public function hydrateHeight(Table $table): void
    {
        $this->databaseSpread->hydrateHeight($table);
    }
}
