<?= $this->extend('Dgvirtual\Demo\Views\layouts\main') ?>

<?= $this->section('content') ?>
<h1>Create User</h1>

<form action="/testusers/save" method="post">
    <fieldset>
        <legend>Main User Info</legend>
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" id="username" class="form-control"
                value="<?= old('username') ?>">
            <?= validation_show_error('username') ?>
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name:</label>
            <input type="text" name="first_name" id="first_name" class="form-control"
                value="<?= old('first_name') ?>">
            <?= validation_show_error('first_name') ?>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name:</label>
            <input type="text" name="last_name" id="last_name" class="form-control"
                value="<?= old('last_name') ?>">
            <?= validation_show_error('last_name') ?>
        </div>

    </fieldset>

    <!-- Add dynamically generated form for user Meta Info fields -->
    <?= view_cell('Dgvirtual\Demo\Cells\TestuserMetaInfo::metaFormFields', ['user' => $user, 'view' => 'meta_edit']) ?>

    <button type="submit" class="btn btn-primary my-4">Create</button>
</form>
<?= $this->endSection() ?>