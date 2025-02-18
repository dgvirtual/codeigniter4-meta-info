<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Support\Database\Seeds;

use Dgvirtual\Demo\Entities\Testuser;
use CodeIgniter\Database\Seeder;

class MetaInfoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'          => 6,
                'resource_id' => 1,
                'class'       => Testuser::class,
                'key'         => 'blog',
                'value'       => 'https://example.com',
                'created_at'  => '2025-02-12 17:03:11',
                'updated_at'  => '2025-02-12 17:03:11',
            ],
            [
                'id'          => 7,
                'resource_id' => 2,
                'class'       => Testuser::class,
                'key'         => 'blog',
                'value'       => 'https://somedomain.net',
                'created_at'  => '2025-02-12 17:03:18',
                'updated_at'  => '2025-02-12 17:03:18',
            ],
            [
                'id'          => 8,
                'resource_id' => 3,
                'class'       => Testuser::class,
                'key'         => 'blog',
                'value'       => 'https://myblog.lt',
                'created_at'  => '2025-02-12 17:03:25',
                'updated_at'  => '2025-02-12 17:03:25',
            ],
            [
                'id'          => 9,
                'resource_id' => 4,
                'class'       => Testuser::class,
                'key'         => 'blog',
                'value'       => 'https://myblog.org',
                'created_at'  => '2025-02-12 17:03:33',
                'updated_at'  => '2025-02-12 17:03:33',
            ],
            [
                'id'          => 10,
                'resource_id' => 5,
                'class'       => Testuser::class,
                'key'         => 'blog',
                'value'       => 'https://myblog.org',
                'created_at'  => '2025-02-12 17:03:33',
                'updated_at'  => '2025-02-12 17:03:33',
            ],
        ];

        // Using Query Builder
        $this->db->table('meta_info')->insertBatch($data);
    }
}
