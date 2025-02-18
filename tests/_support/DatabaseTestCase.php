<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
abstract class DatabaseTestCase extends CIUnitTestCase
{
    use DatabaseTestTrait;

    // SETTINGS FOR MIGRATIONS

    protected $migrate = true;

    // Re-migrate database before each test CLASS is run
    protected $migrateOnce = false;

    /**
     * Should the database be refreshed before each test?
     *
     * @var bool
     */
    // Reset db state before running each test METHOD
    protected $refresh = true;

    /**
     * The namespace(s) to help us find the migration classes.
     * Empty is equivalent to running `spark migrate -all`.
     * Note that running "all" runs migrations in date order,
     * but specifying namespaces runs them in namespace order (then date)
     *
     * @var array|string|null
     */
    protected $namespace = [
        'Dgvirtual\Demo',
        'Dgvirtual\MetaInfo',
    ];

    // SETTINGS FOR SEEDS

    // Re-SEED database before each test CLASS is run
    protected $seedOnce = false;

    /**
     * The seed file(s) used for all tests within this test case.
     * Should be fully-namespaced or relative to $basePath
     *
     * @var array|string
     */
    protected $seed = [
        'Tests\Support\Database\Seeds\TestusersSeeder',
        'Tests\Support\Database\Seeds\MetaInfoSeeder',
    ];

    /**
     * The path to the seeds directory.
     * Allows overriding the default application directories.
     *
     * @var string
     */
    protected $basePath = SUPPORTPATH . 'Database/';

    /**
     * Use for troubleshooting the tests: print the database schema.
     *
     * @return void
     */
    private function outputDatabaseSchema()
    {
        $db     = \Config\Database::connect();
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
        $db      = \Config\Database::connect();
        $query   = $db->table($db->DBPrefix . $tableName)->get();
        $results = $query->getResultArray();

        echo 'Content of table: ' . $db->DBPrefix . $tableName .  \PHP_EOL;

        foreach ($results as $row) {
            print_r($row);
            echo "\n";
        }
    }
}
