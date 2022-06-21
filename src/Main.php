<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread;

use Generator;
use PDO;
use Exception;
use PDOException;

class Main
{
    private DatabaseSpread $databaseSpread;

    public function __construct(
        private PDO $pdo
    ) {
        $this->databaseSpread = new DatabaseSpread($pdo);
    }
    
    public function getTables(): Generator
    {
        try {
            yield from $this->databaseSpread->getTables();

        } catch (Exception $pe) {
            throw new Exception("Possibily a connection error.");
        }
    }

    public function getTablesWithSizes(): Generator
    {
        try {
            yield from $this->databaseSpread->getTablesWithSizes();
        } catch (Exception $pe) {
            throw new Exception("Possibily a connection error.");
        }
    }
}
