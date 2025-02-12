<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Dgvirtual\Demo\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class TestusersSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $dateString = $faker->dateTime->format('Y-m-d H:i:s');
            $data       = [
                'username'   => $faker->userName,
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'created_at' => $dateString,
                'updated_at' => $dateString,
            ];

            $this->db->table('testusers')->insert($data);
        }
    }
}
