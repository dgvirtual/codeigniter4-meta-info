<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Support;

use Config\Database;

trait DatabaseHelperTrait
{
    /**
     * Use for troubleshooting the tests: print the database schema.
     *
     * @return void
     */
    private function outputDatabaseSchema()
    {
        $db     = Database::connect();
        $tables = $db->listTables();

        foreach ($tables as $table) {
            echo "Table: {$table}\n";
            $fields = $db->getFieldData($table);

            foreach ($fields as $field) {
                echo "Field: {$field->name}, Type: {$field->type}, Max Length: {$field->max_length}\n";
            }
            echo "\n";
        }
    }

    /**
     * Prints the content of a table.
     *
     * @param string $tableName The name of the table to print.
     *
     * @return void
     */
    protected function printTableContent(string $tableName)
    {
        $db      = Database::connect();
        $query   = $db->table($db->DBPrefix . $tableName)->get();
        $results = $query->getResultArray();

        echo 'Content of table: ' . $db->DBPrefix . $tableName . "\n";

        foreach ($results as $row) {
            print_r($row);
            echo "\n";
        }
    }
}
