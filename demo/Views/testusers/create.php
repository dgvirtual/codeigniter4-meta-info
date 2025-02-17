<?= $this->extend('Dgvirtual\Demo\Views\layouts\main') ?>

<?= $this->section('content') ?>
<h1>Create User</h1>

<form action="/testusers/save" method="post">
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
    <div class="mb-3">
        <label for="blog" class="form-label">Blog:</label>
        <input type="text" name="meta[blog]" id="blog" class="form-control"
            value="<?= old('meta.blog') ?>">
        <?= validation_show_error('meta.blog') ?>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
<?= $this->endSection() ?>