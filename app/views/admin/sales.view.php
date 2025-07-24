<div class="sales-header">
    <h3 class="header-title">
        <i class="fa fa-money-bill-wave"></i>
        Sales Management
    </h3>
</div>

<div class="sales-stats">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa fa-chart-line"></i>
        </div>
        <div class="stat-value"><?=isset($total_sales) ? $total_sales : '0'?></div>
        <div class="stat-label">Total Sales</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa fa-dollar-sign"></i>
        </div>
        <div class="stat-value">K<?=isset($total_revenue) ? number_format($total_revenue, 2) : '0.00'?></div>
        <div class="stat-label">Total Revenue</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa fa-calendar-day"></i>
        </div>
        <div class="stat-value"><?=isset($today_sales) ? $today_sales : '0'?></div>
        <div class="stat-label">Today's Sales</div>
    </div>
</div>

<div class="sales-table">
    <div class="table-header">
        <h4 class="table-title">
            <i class="fa fa-list"></i>
            Recent Sales
        </h4>
    </div>
    
    <div class="table-container">
        <?php if($sales): ?>
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Date</th>
                        <th>Admin</th>
                        <th>Products</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($sales as $row): ?>
                        <tr>
                            <td>
                                <div class="sale-id">#<?=$row['id']?></div>
                            </td>
                            <td>
                                <div class="sale-date"><?=date("M j, Y", strtotime($row['date']))?></div>
                            </td>
                            <td>
                                <div><?=!empty($row['admin_name']) ? htmlspecialchars($row['admin_name']) : 'N/A'?></div>
                            </td>
                            <td>
                                <?php if (!empty($row['products'])): ?>
                                    <ul style="margin:0; padding-left:18px;">
                                        <?php foreach($row['products'] as $prod): ?>
                                            <li><?=htmlspecialchars($prod) ?: 'N/A'?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="sale-amount">K<?=number_format($row['total'], 2)?></div>
                            </td>
                            <td>
                                <span class="sale-status status-completed">Completed</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="index.php?pg=sale-edit&id=<?=$row['id']?>" class="btn-edit">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </a>
                                    <a href="index.php?pg=sale-delete&id=<?=$row['id']?>" class="btn-delete">
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </a>
                                </div>
                            </td>
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