<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Significant part of the code is borrowed from Bonfire2
 * project, (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 */

namespace Dgvirtual\Demo\Entities;

use CodeIgniter\Entity\Entity;
use Dgvirtual\MetaInfo\Traits\HasMeta;

class Testuser extends Entity
{
    use HasMeta;

    protected string $configClass = 'Testusers';
}
