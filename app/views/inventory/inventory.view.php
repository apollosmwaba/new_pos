<?php require views_path('partials/header');?>


<?php
if (!Auth::access('admin') && !Auth::access('supervisor')) {
    Auth::setMessage("You do not have access to the inventory page");
    require views_path('auth/denied');
    exit;
}
if (isset($_GET['delete_supplier'])) {
    if (!Auth::access('admin')) {
        Auth::setMessage("Only admins can delete suppliers.");
        require views_path('auth/denied');
        exit;
    }
}
?>

<div class="container py-4">
    <?php if (!empty($low_stock)): ?>
        <div class="alert alert-warning mb-4">
            <h4><i class="fa fa-exclamation-triangle me-2"></i>Low Stock Alerts</h4>
            <ul class="mb-0">
                <?php foreach ($low_stock as $item): ?>
                    <li>
                        <strong><?=htmlspecialchars($item['description'])?> (<?=htmlspecialchars($item['sku'])?>)</strong>:
                        Only <span style="color:red; font-weight:bold;"><?=htmlspecialchars($item['quantity'])?></span> left (Min: <?=htmlspecialchars($item['min_stock'])?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fa fa-plus-circle me-2"></i>Stock In (Restocking)
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="stock_in" value="1">
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Product</label>
                            <select name="product_id" id="product_id" class="form-select" required>
                                <option value="">Select Product</option>
                                <?php if (!empty($products) && is_array($products)): ?>
                                    <?php foreach($products as $product): ?>
                                        <option value="<?=$product['id']?>"><?=$product['description']?> (<?=$product['sku']?>)</option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-select" required>
                                <option value="">Select Supplier</option>
                                <?php if (!empty($suppliers) && is_array($suppliers)): ?>
                                    <?php foreach($suppliers as $supplier): ?>
                                        <option value="<?=$supplier['id']?>"><?=$supplier['name']?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cost" class="form-label">Cost per Unit</label>
                            <input type="number" step="0.01" name="cost" id="cost" class="form-control" min="0" required>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Stock</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="fa fa-minus-circle me-2"></i>Stock Out (Adjustments)
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="stock_out" value="1">
                        <div class="mb-3">
                            <label for="product_id_out" class="form-label">Product</label>
                            <select name="product_id" id="product_id_out" class="form-select" required>
                                <option value="">Select Product</option>
                                <?php if (!empty($products) && is_array($products)): ?>
                                    <?php foreach($products as $product): ?>
                                        <option value="<?=$product['id']?>"><?=$product['description']?> (<?=$product['sku']?>)</option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity_out" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity_out" class="form-control" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason</label>
                            <select name="reason" id="reason" class="form-select" required>
                                <option value="">Select Reason</option>
                                <option value="Spoilage">Spoilage</option>
                                <option value="Theft">Theft</option>
                                <option value="Manual Adjustment">Manual Adjustment</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-minus"></i> Reduce Stock</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <i class="fa fa-history me-2"></i>Audit Trail (Recent Stock Movements)
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Reason</th>
                        <th>Supplier</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($audit_trail) && is_array($audit_trail)): ?>
                        <?php foreach ($audit_trail as $row): ?>
                            <tr>
                                <td><?=htmlspecialchars($row['created_at'])?></td>
                                <td><?=htmlspecialchars($row['product_name'])?></td>
                                <td><?=htmlspecialchars(ucfirst($row['type']))?></td>
                                <td><?=htmlspecialchars($row['quantity'])?></td>
                                <td><?=htmlspecialchars($row['reason'])?></td>
                                <td>
                                    <?php if (!empty($row['supplier_id'])): ?>
                                        <?php
                                        $supplier_name = '';
                                        if (!empty($suppliers) && is_array($suppliers)) {
                                            foreach ($suppliers as $s) {
                                                if ($s['id'] == $row['supplier_id']) {
                                                    $supplier_name = $s['name'];
                                                    break;
                                                }
                                            }
                                        }
                                        echo htmlspecialchars($supplier_name);
                                        ?>
                                    <?php endif; ?>
                                </td>
                                <td><?=htmlspecialchars($row['user_name'])?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No stock movements found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
            <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fa fa-chart-bar me-2"></i>Inventory Reports
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs mb-3" id="reportTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="stock-tab" data-bs-toggle="tab" data-bs-target="#stock" type="button" role="tab">Current Stock</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">Stock History</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="fast-tab" data-bs-toggle="tab" data-bs-target="#fast" type="button" role="tab">Fast/Slow Movers</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="suppliers-tab" data-bs-toggle="tab" data-bs-target="#suppliers" type="button" role="tab">Suppliers</button>
                </li>
            </ul>
            <div class="tab-content" id="reportTabsContent">
                <div class="tab-pane fade show active" id="stock" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr><th>Product</th><th>SKU</th><th>Quantity</th><th>Cost Price</th><th>Stock Value</th></tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($current_stock) && is_array($current_stock)): ?>
                                    <?php foreach($current_stock as $row): ?>
                                        <tr>
                                            <td><?=htmlspecialchars($row['description'])?></td>
                                            <td><?=htmlspecialchars($row['sku'])?></td>
                                            <td><?=htmlspecialchars($row['quantity'])?></td>
                                            <td><?=htmlspecialchars($row['cost_price'])?></td>
                                            <td><?=number_format($row['stock_value'],2)?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5">No data found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="history" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr><th>Date</th><th>Product</th><th>Type</th><th>Qty</th><th>Reason</th><th>User</th></tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($stock_history) && is_array($stock_history)): ?>
                                    <?php foreach($stock_history as $row): ?>
                                        <tr>
                                            <td><?=htmlspecialchars($row['created_at'])?></td>
                                            <td><?=htmlspecialchars($row['product_name'])?></td>
                                            <td><?=htmlspecialchars($row['type'])?></td>
                                            <td><?=htmlspecialchars($row['quantity'])?></td>
                                            <td><?=htmlspecialchars($row['reason'])?></td>
                                            <td><?=htmlspecialchars($row['user_name'])?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="6">No data found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="fast" role="tabpanel">
                    <h5 class="mt-3">Top 5 Fast Movers</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark"><tr><th>Product</th><th>SKU</th><th>Total Moved</th></tr></thead>
                            <tbody>
                                <?php if (!empty($fast_movers) && is_array($fast_movers)): ?>
                                    <?php foreach($fast_movers as $row): ?>
                                        <tr>
                                            <td><?=htmlspecialchars($row['description'])?></td>
                                            <td><?=htmlspecialchars($row['sku'])?></td>
                                            <td><?=htmlspecialchars($row['total_moved'])?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3">No data found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <h5 class="mt-4">Top 5 Slow Movers</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark"><tr><th>Product</th><th>SKU</th><th>Total Moved</th></tr></thead>
                            <tbody>
                                <?php if (!empty($slow_movers) && is_array($slow_movers)): ?>
                                    <?php foreach($slow_movers as $row): ?>
                                        <tr>
                                            <td><?=htmlspecialchars($row['description'])?></td>
                                            <td><?=htmlspecialchars($row['sku'])?></td>
                                            <td><?=htmlspecialchars($row['total_moved'])?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3">No data found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="suppliers" role="tabpanel">
                    <div class="card mb-3">
                        <div class="card-header bg-secondary text-white">
                            <i class="fa fa-truck me-2"></i>Add Supplier
                        </div>
                        <div class="card-body">
                            <form method="post" class="mb-3">
                                <input type="hidden" name="add_supplier" value="1">
                                <div class="mb-2">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label>Contact Info</label>
                                    <textarea name="contact_info" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Supplier</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <i class="fa fa-list me-2"></i>All Suppliers
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark"><tr><th>Name</th><th>Contact</th><th>Actions</th></tr></thead>
                                <tbody>
                                    <?php if (!empty($all_suppliers) && is_array($all_suppliers)): ?>
                                        <?php foreach($all_suppliers as $s): ?>
                                            <tr>
                                                <td><?=htmlspecialchars($s['name'])?></td>
                                                <td><?=htmlspecialchars($s['contact_info'])?></td>
                                                <td>
                                                    <a href="?pg=inventory&delete_supplier=<?=$s['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this supplier?')"><i class="fa fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="3">No suppliers found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ FIX: Added JavaScript for inventory reports tab switching -->
<!-- ✳️ BUG: Previously, DOM elements were present but JavaScript switch logic was missing -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ✅ FIX: Activated tab switching logic in Inventory Reports section
    // ✳️ BUG: DOM elements were present but JavaScript switch logic was missing
    
    const tabButtons = document.querySelectorAll('#reportTabs .nav-link');
    const tabPanes = document.querySelectorAll('#reportTabsContent .tab-pane');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all buttons and panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => {
                pane.classList.remove('show', 'active');
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Show corresponding tab pane
            const targetId = this.getAttribute('data-bs-target');
            const targetPane = document.querySelector(targetId);
            if (targetPane) {
                targetPane.classList.add('show', 'active');
            }
        });
    });
    
    // Initialize first tab as active
    if (tabButtons.length > 0) {
        tabButtons[0].classList.add('active');
        if (tabPanes.length > 0) {
            tabPanes[0].classList.add('show', 'active');
        }
    }
});
</script>

<?php require views_path('partials/footer');?>