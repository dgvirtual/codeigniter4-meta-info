<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Dgvirtual\Demo\Cells;

/**
 * Provides view cells for Users
 */
class TestuserMetaInfo
{
    /**
     * Displays the form fields for Users meta fields.
     *
     * @param mixed $user
     * @param mixed $view
     */
    public function metaFormFields($user, $view = 'meta_edit')
    {
        return view('Dgvirtual\MetaInfo\\' . $view, [
            'fieldGroups' => $this->augmentMetafields(),
            'user'        => $user,
        ]);
    }

    private function augmentMetafields()
    {
        $metaFields    = config('Testusers')->metaFields;
        $metaFieldsUpd = [];

        foreach ($metaFields as $fieldGroup => $groupValue) {
            foreach ($groupValue as $key => $value) {
                if (! isset($value['label'])) {
                    $metaFields[$fieldGroup][$key]['label'] = esc(ucwords(strtolower(str_replace(['-', '_'], ' ', $key))));
                } elseif (lang($value['label']) !== $value['label']) {
                    // if !==, there is a translation string, use it
                    $metaFields[$fieldGroup][$key]['label'] = lang($value['label']);
                }
            }
            // dd(lang($fieldGroup));
            if (lang($fieldGroup) !== $fieldGroup) {
                $metaFieldsUpd[lang($fieldGroup)] = $metaFields[$fieldGroup];
            } else {
                $metaFieldsUpd[$fieldGroup] = $metaFields[$fieldGroup];
            }
        }

        return $metaFieldsUpd;
    }
}
