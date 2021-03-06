<?php

namespace DefStudio\WiredTables\Exceptions;

class ColumnException extends \Exception
{
    public static function noColumnDefined(string $tableClass): ColumnException
    {
        return new ColumnException("No column defined for table [$tableClass]");
    }

    public static function locked(): ColumnException
    {
        return new ColumnException("Columns can be added only inside WiredTable::columns() method");
    }

    public static function duplicatedColumn(string $name): ColumnException
    {
        return new ColumnException("Duplicated column [$name]");
    }

    public static function notFound(string $name): ColumnException
    {
        return new ColumnException("Column not found: [$name]");
    }
}
