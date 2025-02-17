<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests;

use Tests\Support\DatabaseTestCase;

/**
 * @internal
 */
final class SimpleTest extends DatabaseTestCase
{
    public function testSeedingSuccess()
    {
        $criteria = [
            'class' => 'Dgvirtual\Demo\Entities\Testuser',
            'key'   => 'blog',
            'value' => 'https://somedomain.net',
        ];
        $this->seeInDatabase('meta_info', $criteria);

        $criteria = [
            'username'   => 'walker',
            'first_name' => 'Minnie',
            'last_name'  => 'Thiel',
        ];
        $this->seeInDatabase('testusers', $criteria);

        // do we have the expected number of entries in db table?
        $criteria = [
            'class' => 'Dgvirtual\Demo\Entities\Testuser',
        ];
        $this->seeNumRecords(5, 'meta_info', $criteria);
    }
}
