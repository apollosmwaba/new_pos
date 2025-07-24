<div class="admin-table-container">
    <div class="table-header">
        <h4><i class="fa fa-users me-2"></i>Users</h4>
        <a href="index.php?pg=signup" class="btn btn-primary"><i class="fa fa-plus"></i> Add User</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?=htmlspecialchars($user['id'])?></td>
                            <td><?=htmlspecialchars($user['username'])?></td>
                            <td><?=htmlspecialchars($user['role'])?></td>
                            <td><?=htmlspecialchars($user['email'])?></td>
                            <td><?=htmlspecialchars($user['date'])?></td>
                            <td>
                                <a href="index.php?pg=edit-user&id=<?=$user['id']?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                                <a href="index.php?pg=delete-user&id=<?=$user['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>