<?= $this->extend('Dgvirtual\Demo\Views\layouts\main') ?>

<?= $this->section('content') ?>
    <h1>Meta Info Table</h1>
    <p>This is a raw view of database table `meta_info`</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>id</th>
                <th>resource_id</th>
                <th>class</th>
                <th>key</th>
                <th>value</th>
                <th>created_at</th>
                <th>updated_at</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($meta_info as $info): ?>
                <tr>
                    <td><?= esc($info->id) ?></td>
                    <td><?= esc($info->resource_id) ?></td>
                    <td><?= esc($info->class) ?></td>
                    <td><?= esc($info->key) ?></td>
                    <td><?= esc($info->value) ?></td>
                    <td><?= esc($info->created_at) ?></td>
                    <td><?= esc($info->updated_at) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>