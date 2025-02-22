<?= $this->extend('Dgvirtual\Demo\Views\layouts\main') ?>

<?= $this->section('content') ?>
<h1>Display User</h1>

<div class="btn-group my-3">
    <a href="/testusers/edit/<?= $user->id ?>" class="btn btn-warning btn-sm">Edit</a>
    <a href="/testusers/delete/<?= $user->id ?>" onclick="return confirm('Are you sure you want to delete the user?')" class="btn btn-danger btn-sm">Delete</a>
</div>

<table class="table table-bordered">
    <tr>
        <th colspan="2" class="table-secondary">Main User Info</th>
    </tr>
    <tr>
        <th>Username:</th>
        <td><?= esc($user->username) ?></td>
    </tr>
    <tr>
        <th>First Name:</th>
        <td><?= esc($user->first_name) ?></td>
    </tr>
    <tr>
        <th>Last Name:</th>
        <td><?= esc($user->last_name) ?></td>
    </tr>
    <tr>
        <th>Created At:</th>
        <td><?= esc($user->created_at) ?></td>
    </tr>
    <tr>
        <th>Updated At:</th>
        <td><?= esc($user->updated_at) ?></td>
    </tr>

    <!-- Add dynamically generated display for user Meta Info fields -->
    <?= view_cell('Dgvirtual\Demo\Cells\TestuserMetaInfo::metaFormFields', ['user' => $user, 'view' => 'meta_display']) ?>

</table>

<a href="<?= base_url('/testusers') ?>" class="btn btn-primary my-4">Back to List</a>

<?= $this->endSection() ?>