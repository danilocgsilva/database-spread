<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpread;

use Generator;
use PDO;
use Exception;
use PDOException;

class Main
{
    private PDO $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function getTables(): Generator
    {
        try {
            $resource = $this->pdo->query("SHOW TABLES");
            foreach ($resource->fetchAll(PDO::FETCH_NUM) as $row) {
                yield $row[0];
            }
        } catch (PDOException $pe) {
            throw new Exception("Possibily a connection error.");
        } catch (Exception $e) {
            throw new Exception("Error unhandleable.");
        }
    }
}
