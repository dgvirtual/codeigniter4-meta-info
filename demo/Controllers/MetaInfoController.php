<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Dgvirtual\Demo\Controllers;

use CodeIgniter\Controller;
use Dgvirtual\MetaInfo\Models\MetaModel;

class MetaInfoController extends Controller
{
    /**
     * List meta info.
     *
     * @return string
     */
    public function index()
    {
        $data['meta_info'] = model(MetaModel::class)->findAll();

        return view('Dgvirtual\Demo\meta_info\index', $data);
    }
}
