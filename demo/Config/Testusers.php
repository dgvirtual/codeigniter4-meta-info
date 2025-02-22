<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Dgvirtual\Demo\Config;

use CodeIgniter\Config\BaseConfig;

class Testusers extends BaseConfig
{
    /**
     * ---------------------------------------------------
     * Extra fields to store in meta_info table
     * ---------------------------------------------------
     * second level array keys should be unique accross this array
     *
     * Supported `type` values: checkbox, textarea, text
     * (and variants of text: number, password, email, tel,
     * url, date, time, week, month, color)
     */
    public $metaFields = [
        'Social Links' => [
            'blog' => [
                'label'      => 'Blog',
                'type'       => 'text',
                'validation' => 'permit_empty|valid_url_strict',
            ],
            'email' => [
                'label'      => 'Email',
                'type'       => 'text',
                'validation' => 'permit_empty|valid_email',
            ],
        ],
        'User Is...' => [
            'catperson' => [
                'label'      => 'Cat Person',
                'type'       => 'checkbox',
                'validation' => 'permit_empty',
            ],
            'dogperson' => [
                'label'      => 'Dog Person',
                'type'       => 'checkbox',
                'validation' => 'permit_empty',
            ],
        ],
    ];

    /**
     * ---------------------------------------------------
     * Search in extra fields
     * ---------------------------------------------------
     * To enable search in additional user fields, add the
     * field names to this array.
     */
    public $includeMetaFieldsInSearch = [
        'blog',
        'email',
    ];
}
