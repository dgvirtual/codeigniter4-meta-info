<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Dgvirtual\MetaInfo\Traits;

trait WithMeta
{
    /**
     * Custom method to join the meta_info table.
     *
     * @param string $className The resource entity class namespaced name that the
     *                          data is associated with in meta_info table.
     * @param string $tableName The name of the table to join meta_info to.
     *
     * @return $this
     */
    public function joinMetaInfo($className)
    {
        $this->join('meta_info m', $this->table . '.id = m.resource_id AND m.class = "' . $className . '"', 'left');

        return $this;
    }

    /**
     * Custom method to do a like query on meta_info table during search.
     *
     * @param string    $field             The key to search for.
     * @param mixed     $match             The value to search for.
     * @param string    $side              The side to add the wildcard ('both', 'left', 'right', or 'none').
     * @param bool|null $escape            Whether to escape the value.
     * @param bool      $insensitiveSearch Whether to perform a case-insensitive search.
     *
     * @return $this
     */
    public function orLikeInMetaInfo($field, $match, $side = 'both', $escape = null, $insensitiveSearch = false)
    {
        $this->orGroupStart()
            ->where('m.key', $field)
            ->like('m.value', $match, $side, $escape, $insensitiveSearch)
            ->groupEnd();

        return $this;
    }

    // Custom method to encapsulate orGroupStart block for "where" mode
    public function orMetaInfoWhere($key, $value)
    {
        $this->orGroupStart()
            ->where('m.key', $key)
            ->where('m.value', $value)
            ->groupEnd();

        return $this;
    }

    // Custom method to generate the MAX(CASE WHEN ...) SQL expression
    public function metaInfoColumn($column)
    {
        return "MAX(CASE WHEN m.key = \"{$column}\" THEN m.value END) AS {$column}";
    }

    /**
     * Generates the select clause for meta fields.
     *
     * @param array  $metaFields The meta fields to include in the select clause.
     * @param string $className  The class name of the entity.
     * @param string $tableName  The name of the main table.
     *
     * @return string The generated select clause.
     */
    public function generateMetaSelectClause(array $metaFields, string $className): string
    {
        $selectClause = "{$this->table}.*";

        foreach ($metaFields as $metaField) {
            $selectClause .= ", (SELECT value FROM meta_info WHERE meta_info.resource_id = {$this->table}.id AND meta_info.class = '{$className}' AND meta_info.key = '{$metaField}' LIMIT 1) as {$metaField}";
        }

        return $selectClause;
    }
}
