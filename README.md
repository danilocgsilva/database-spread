# database-spread

Utility to check relational database structure, relationships and complexity

## What if...

* Get a model/entity table and spread across other tables which have relationships to this one?

* Count the total number of fields of the table and all related tables to give an idea of the total entity properties.

## How to use?

### Instantiating the object
```
$pdo = new \PDO($connection, $user, $password);
$databaseSpread = Danilocgsilva\DatabaseSpread($pdo);
$databaseSpread->setDatabaseName("DATABASE_name");
```

### Using the object

Listing tables:
```
$databaseSpread->getTables()
```

Listing tables with sizes:
```
$databaseSpread->getTablesWithSizes()
```

Get all fields from a table:

```
$databaseSpread->getFields(string $tableName)
```

The `getTables()`, `getTablesWithSizes()` and `getFields()` returns a `Transversable` object.
