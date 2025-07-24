<?php require views_path('partials/header'); ?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="fa fa-book"></i> Register</h2>
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
        <div class="col-md-12 mb-4">
            <h4>Sales Log</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Sale Time</th>
                        <th>Total Amount</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sales_logs)): ?>
                        <?php foreach ($sales_logs as $log): ?>
                            <tr>
                                <td><?=esc($log['id'])?></td>
                                <td><?=esc($log['user_id'])?></td>
                                <td><?=esc($log['sale_time'])?></td>
                                <td><?=esc($log['total_amount'])?></td>
                                <td><?=esc($log['details'])?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">No sales logs found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 mb-4">
            <h4>Audit Log</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Action Type</th>
                        <th>Action Time</th>
                        <th>Description</th>
                        <th>Related Sale ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($audit_logs)): ?>
                        <?php foreach ($audit_logs as $log): ?>
                            <tr>
                                <td><?=esc($log['id'])?></td>
                                <td><?=esc($log['user_id'])?></td>
                                <td><?=esc($log['action_type'])?></td>
                                <td><?=esc($log['action_time'])?></td>
                                <td><?=esc($log['description'])?></td>
                                <td><?=esc($log['related_sale_id'])?></td>
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