<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestusersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'spencer',
                'first_name' => 'Mafalda',
                'last_name'  => 'Baumbach',
                'created_at' => '2024-02-12 13:13:32',
                'updated_at' => '2024-02-12 13:13:32',
            ],
            [
                'username'   => 'benny57',
                'first_name' => 'Baumbach',
                'last_name'  => 'Hettinger',
                'created_at' => '2024-12-30 01:59:13',
                'updated_at' => '2024-12-30 01:59:13',
            ],
            [
                'username'   => 'walker',
                'first_name' => 'Minnie',
                'last_name'  => 'Thiel',
                'created_at' => '2010-01-05 13:59:10',
                'updated_at' => '2010-01-05 13:59:10',
            ],
            [
                'username'   => 'zwiza',
                'first_name' => 'Demetrius',
                'last_name'  => 'Cronin',
                'created_at' => '2022-12-31 08:39:33',
                'updated_at' => '2022-12-31 08:39:33',
            ],
            [
                'username'   => 'gemmerich',
                'first_name' => 'Muhammad',
                'last_name'  => 'Marvin',
                'created_at' => '2027-05-11 07:37:37',
                'updated_at' => '2027-05-11 07:37:37',
            ],
            [
                'username'   => 'hzemlak',
                'first_name' => 'Margarete',
                'last_name'  => 'Koss',
                'created_at' => '2023-09-20 13:23:03',
                'updated_at' => '2023-09-20 13:23:03',
            ],
            [
                'username'   => 'shirley93',
                'first_name' => 'Christ',
                'last_name'  => 'Kozey',
                'created_at' => '2014-06-20 15:56:11',
                'updated_at' => '2014-06-20 15:56:11',
            ],
            [
                'username'   => 'konopelski',
                'first_name' => 'Vincenzo',
                'last_name'  => 'Fay',
                'created_at' => '1987-02-26 14:15:17',
                'updated_at' => '1987-02-26 14:15:17',
            ],
            [
                'username'   => 'stephany',
                'first_name' => 'Derek',
                'last_name'  => 'Stracke',
                'created_at' => '2025-01-21 22:44:48',
                'updated_at' => '2025-01-21 22:44:48',
            ],
            [
                'username'   => 'susanna50',
                'first_name' => 'Richard',
                'last_name'  => 'Cartwright',
                'created_at' => '2024-06-15 10:23:17',
                'updated_at' => '2024-06-15 10:23:17',
            ],
            [
                'username'   => 'susanna52',
                'first_name' => 'Susan',
                'last_name'  => 'Palmer',
                'created_at' => '2024-06-15 10:23:17',
                'updated_at' => '2024-06-15 10:23:17',
            ],
        ];

        foreach ($data as $user) {
            $this->db->table('testusers')->insert($user);
        }
    }
}