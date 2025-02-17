<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Models;

use Dgvirtual\Demo\Models\TestuserModel;
use Tests\Support\DatabaseTestCase;

/**
 * @internal
 */
final class TestuserModelTest extends DatabaseTestCase
{
    public function testSearch()
    {
        $model = new TestuserModel();

        $results = $model->search('Mafalda');

        $this->assertCount(1, $results);
        $this->assertSame('Mafalda', $results[0]->first_name);

        // Test search by last name
        $results = $model->search('Baumbach');
        $this->assertCount(2, $results);
        $this->assertSame('Mafalda', $results[0]->first_name);
        $this->assertSame('Baumbach', $results[1]->first_name);

        // Test search by username
        $results = $model->search('walker');
        $this->assertCount(1, $results);
        $this->assertSame('walker', $results[0]->username);

        // Test search by meta field
        $results = $model->search('https://example.com');
        $this->assertCount(1, $results);
        $this->assertSame('spencer', $results[0]->username);

        // Test search with no results
        $results = $model->search('nonexistent');
        $this->assertCount(0, $results);
    }
}
