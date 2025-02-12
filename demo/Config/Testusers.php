<?php

namespace Dgvirtual\Demo\Config;

use CodeIgniter\Config\BaseConfig;

class Testusers extends BaseConfig
{
    /**
      * ---------------------------------------------------
      * Extra fields to store in meta_info table
      * ---------------------------------------------------
      * To enable search in additional user fields, add the
      * field names to this array.
      */
    public $metaFields = [
        'Social Links' => [
            'blog' => [
              'label' => 'Blog',
              'type' => 'text',
              'validation' => 'permit_empty|valid_url_strict'
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
    ];
}
