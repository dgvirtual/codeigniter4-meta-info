<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Significant part of the code is adapted from Bonfire2
 * project, (c) Lonnie Ezell <lonnieje@gmail.com>
 */

namespace Dgvirtual\MetaInfo\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMetaInfoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'int',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'resource_id' => [
                'type'       => 'int',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'class' => [
                'type'       => 'varchar',
                'constraint' => 255,
            ],
            'key' => [
                'type'       => 'varchar',
                'constraint' => 255,
            ],
            'value' => [
                'type' => 'text',
                'null' => true,
            ],
            'created_at' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('resource_id');
        $this->forge->createTable('meta_info', true);
    }

    public function down()
    {
        $this->forge->dropTable('meta_info', true);
    }
}
