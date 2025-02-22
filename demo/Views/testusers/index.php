<?= $this->extend('Dgvirtual\Demo\Views\layouts\main') ?>

<?= $this->section('content') ?>
    <h1>Users List</h1>

    <!-- Search Form -->
    <form method="get" action="<?= site_url('testusers') ?>" class="mb-3" style="max-width: 500px;">
        <div class="input-group">
            <input type="text" name="term" value="<?= esc($term) ?>" class="form-control" placeholder="Search users...">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <a href="/testusers/create" class="btn btn-primary mb-3">Create New User</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Blog</th>
                <th>Email</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->first_name ?></td>
                    <td><?= $user->last_name ?></td>
                    <td><?= $user->blog ?></td>
                    <td><?= $user->email ?></td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="/testusers/display/<?= $user->id ?>" class="btn btn-primary btn-sm">Display</a>
                            <a href="/testusers/edit/<?= $user->id ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/testusers/delete/<?= $user->id ?>" onclick="return confirm('Are you sure you want to delete the user?')" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>
