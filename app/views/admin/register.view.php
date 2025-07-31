
<div class="container mt-4">
    
    <div class="row">
        <div class="col-md-12 mb-4">
            <h4>Session Log</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Role</th>
                        <th>Login Time</th>
                        <th>Logout Time</th>
                        <th>Session Duration (s)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($session_logs)): ?>
                        <?php foreach ($session_logs as $log): ?>
                            <tr>
                                <td><?=esc($log['id'])?></td>
                                <td><?=esc($log['user_id'])?></td>
                                <td><?=esc($log['role'])?></td>
                                <td><?=esc($log['login_time'])?></td>
                                <td><?=esc($log['logout_time'])?></td>
                                <td><?=esc($log['session_duration'])?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">No session logs found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Recent Sales Table -->
        <form method="post" action="/p1/app/controllers/sale-clear.php" onsubmit="return confirm('Are you sure you want to erase all sales logs? This action cannot be undone.');" style="display:inline;">
    <button type="submit" class="btn btn-danger mb-2">
        <i class="fa fa-trash"></i> Erase All Sales Log
    </button>
</form>

<div class="card mb-4">
            <div class="card-header">
                <b>Sales Log </b>
            </div>
            <div class="card-body table-responsive" style="max-height: 350px; overflow-y: auto;">
                <?php if ($sales): ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sale ID</th>
                                <th>Date</th>
                                <th>Admin</th>
                                <th>Products</th>
                                <th>Amount</th>
                                <th>Status</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sales as $row): ?>
                                <tr>
                                    <td><div class="sale-id">#<?= $row['id'] ?></div></td>
                                    <td><div class="sale-date"><?= date("M j, Y", strtotime($row['date'])) ?></div></td>
                                    <td><div><?= !empty($row['admin']) ? htmlspecialchars($row['admin']) : 'N/A' ?></div></td>
                                    <td>
                                        <?php
                                        // Try to get products as a bullet list
                                        $products = [];
                                        if (!empty($row['description'])) {
                                            $products = explode(',', $row['description']);
                                        }
                                        ?>
                                        <?php if (!empty($products)): ?>
                                            <ul style="margin:0; padding-left:18px;">
                                                <?php foreach ($products as $prod): ?>
                                                    <li><?= htmlspecialchars($prod) ?: 'N/A' ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td><div class="sale-amount">K<?= number_format($row['total'], 2) ?></div></td>
                                    <td><span class="sale-status status-completed">Completed</span></td>
                                    
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fa fa-money-bill-wave"></i>
                        </div>
                        <h4 class="empty-title">No Sales Found</h4>
                        <p class="empty-subtitle">Sales will appear here once transactions are made</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <h4>Audit Log</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <!-- <th>Action Type</th> -->
                        <th>Action Time</th>
                        <th>Description</th>
                        <!-- <th>Related Sale ID</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($audit_logs)): ?>
                        <?php foreach ($audit_logs as $log): ?>
                            <tr>
                                <td><?=esc($log['id'])?></td>
                                <td><?=esc($log['user_id'])?></td>
                                <!-- <td><?=esc($log['action_type'])?></td> -->
                                <td><?=esc($log['action_time'])?></td>
                                <td><?=esc($log['description'])?></td>
                                <!-- <td><?=esc($log['related_sale_id'])?></td> -->
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">No audit logs found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require views_path('partials/footer'); ?> 