<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h1>Users List</h1>

    <!-- Search Form -->
    <form method="get" action="<?= site_url('testusers') ?>" class="mb-3" style="max-width: 500px;">
        <div class="input-group">
            <input type="text" name="term" value="<?= esc($term) ?>" class="form-control" placeholder="Search users...">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <a href="/users/create" class="btn btn-primary mb-3">Create New User</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Blog</th>
                <th>Actions</th>
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
                    <td>
                        <a href="/testusers/edit/<?= $user->id ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/testusers/delete/<?= $user->id ?>" method="post" style="display:inline;">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>
