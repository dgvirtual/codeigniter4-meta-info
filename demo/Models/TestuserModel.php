<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Dgvirtual\Demo\Models;

use Dgvirtual\Demo\Config\Testusers;
use CodeIgniter\Model;
use Dgvirtual\Demo\Entities\Testuser;
use Dgvirtual\MetaInfo\Traits\WithMeta;

class TestuserModel extends Model
{
    use WithMeta;

    protected $table         = 'testusers';
    protected $primaryKey    = 'id';
    protected $returnType    = Testuser::class;
    protected $allowedFields = ['username', 'first_name', 'last_name', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // skip validation, as we will be importing the rules to controller for validation
    protected $skipValidation = true;

    /**
     * @var array The validation rules for the model.
     */
    public $validationRules = [
        'id'       => 'permit_empty|is_natural_no_zero',
        'username' => [
            'label' => 'Username',
            'rules' => 'required|max_length[100]',
        ],
        'first_name' => [
            'label' => 'First Name',
            'rules' => 'required|max_length[100]',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'rules' => 'required|max_length[100]',
        ],
    ];

    /**
     * Performs a primary search for index page
     */
    public function search(string $term, int $limit = 100, int $offset = 0): array
    {
        $termInMeta = config(Testusers::class)->includeMetaFieldsInSearch;

        // Generate the select clause using the WithMeta trait method
        $selectClause = $this->generateMetaSelectClause($termInMeta, Testuser::class);

        $query = $this->select($selectClause)->distinct();

        if (! empty($termInMeta)) {
            // TODO: find a better way to access the Entity to which the data is assigned to join meta_info with
            $query->joinMetaInfo(Testuser::class);
        }

        if ($term) {
            $query->like('first_name', $term, 'right', true, true)
                ->orLike('last_name', $term, 'right', true, true)
                ->orLike('username', $term, 'right', true, true);

            if (! empty($termInMeta)) {
                foreach ($termInMeta as $metaField) {
                    $query->orLikeInMetaInfo($metaField, $term, 'both', true, true);
                }
            }
        }

        return $query->findAll($limit, $offset);
    }
}
