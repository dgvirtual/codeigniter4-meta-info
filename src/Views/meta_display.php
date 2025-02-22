<?php if (isset($fieldGroups) && count($fieldGroups)) : ?>
    <?php foreach ($fieldGroups as $group => $fields) : ?>
        <tr>
            <th colspan="2" class="table-secondary"><?= esc($group) ?></th>
        </tr>
        <?php foreach ($fields as $field => $info) : ?>
            <tr>
                <th><?= esc($info['label'] ?? ucwords(strtolower(str_replace(['-', '_'], ' ', $field)))) ?>:</th>
                <td><?= esc($user->meta(strtolower($field)) ?? '') ?></td>
            </tr>
        <?php endforeach ?>
    <?php endforeach ?>
<?php endif ?>