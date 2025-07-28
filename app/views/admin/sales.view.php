<?php
// ✅ ADDED FROM POS2 - Sales Dashboard Enhancement on 2024-12-19
// REASON: Added POS2 feature to POS1 for consistent modern UI experience
?>
<style>
.sales-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 25px;
    flex-wrap: wrap;
    gap: 15px;
}

.header-title {
    color: #2c3e50;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sales-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    text-align: center;
    border-left: 4px solid #e74c3c;
}

.stat-icon {
    font-size: 32px;
    color: #e74c3c;
    margin-bottom: 10px;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 5px;
}

.stat-label {
    color: #6c757d;
    font-size: 14px;
    font-weight: 500;
}

.sales-table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.table-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 20px;
    border-bottom: 2px solid #e9ecef;
}

.table-title {
    color: #2c3e50;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.table-container {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.modern-table th {
    background: #f8f9fa;
    color: #495057;
    font-weight: 600;
    padding: 15px;
    text-align: left;
    border-bottom: 2px solid #e9ecef;
}

.modern-table td {
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.modern-table tr:hover {
    background: rgba(231, 76, 60, 0.05);
}

.sale-id {
    font-weight: 600;
    color: #2c3e50;
    font-family: 'Courier New', monospace;
}

.sale-date {
    color: #6c757d;
    font-size: 14px;
}

.sale-amount {
    color: #e74c3c;
    font-weight: 700;
    font-size: 18px;
}

.sale-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-completed {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.status-pending {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-edit {
    background: #007bff;
    border: none;
    border-radius: 8px;
    padding: 8px 12px;
    color: white;
    font-size: 12px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
}

.btn-edit:hover {
    background: #0056b3;
    color: white;
    transform: scale(1.05);
    text-decoration: none;
}

.btn-delete {
    background: #dc3545;
    border: none;
    border-radius: 8px;
    padding: 8px 12px;
    color: white;
    font-size: 12px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
}

.btn-delete:hover {
    background: #c82333;
    color: white;
    transform: scale(1.05);
    text-decoration: none;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-icon {
    font-size: 48px;
    color: #e9ecef;
    margin-bottom: 20px;
}

.empty-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #495057;
}

.empty-subtitle {
    font-size: 16px;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .sales-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .sales-stats {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .modern-table th,
    .modern-table td {
        padding: 10px 8px;
        font-size: 14px;
    }
}
</style>

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