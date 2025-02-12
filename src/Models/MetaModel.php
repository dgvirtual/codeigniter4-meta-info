<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 */

namespace Dgvirtual\MetaInfo\Models;

use CodeIgniter\Model;

class MetaModel extends Model
{
    protected $table         = 'meta_info';
    protected $allowedFields = ['class', 'resource_id', 'key', 'value'];
    protected $returnType    = 'object';
    protected $useTimestamps = true;
}
