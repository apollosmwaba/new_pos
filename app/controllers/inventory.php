<?php

require_once "../app/models/Inventory.php";
require_once "../app/models/StockMovement.php";
require_once "../app/models/Product.php";
require_once "../app/models/Supplier.php";

if (!Auth::access('admin') && !Auth::access('supervisor')) {
    Auth::setMessage("You do not have access to the inventory page");
    require views_path('auth/denied');
    exit;
}

$inventory = new Inventory();
$stockMovement = new StockMovement();
$productModel = new Product();
$supplierModel = new Supplier();

// ✅ LOGIC TRANSFERRED: One-time sync logic copied from POS2 -> POS1
// ✳️ SOURCE: POS2 inventory.php one-time sync section

// One-time sync: Ensure all products have an inventory entry
$allProducts = $productModel->getAll(1000,0,'desc','id');
foreach ($allProducts as $product) {
    $inv = $inventory->getByProduct($product['id']);
    if (!$inv) {
        $inventory->insert([
            'product_id' => $product['id'],
            'quantity' => $product['qty'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}

// ✅ LOGIC TRANSFERRED: Stock in logic copied from POS2 -> POS1
// ✳️ SOURCE: POS2 inventory.php stock in section

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stock_in'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $supplier_id = $_POST['supplier_id'];
    $cost = $_POST['cost'];
    $user_id = Auth::get('id');

    // Update inventory
    $inventory->stockIn($product_id, $quantity);

    // Log movement
    $stockMovement->log([
        'product_id' => $product_id,
        'user_id' => $user_id,
        'type' => 'in',
        'quantity' => $quantity,
        'reason' => 'Restock',
        'supplier_id' => $supplier_id,
        'cost' => $cost,
        'created_at' => date('Y-m-d H:i:s')
    ]);

    // Optionally, set a success message
    Auth::setMessage("Stock added successfully!");
    // Redirect or reload as needed
}

// ✅ LOGIC TRANSFERRED: Stock out logic copied from POS2 -> POS1
// ✳️ SOURCE: POS2 inventory.php stock out section

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stock_out'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $reason = $_POST['reason'];
    $user_id = Auth::get('id');

    // Update inventory (decrease stock)
    $success = $inventory->stockOut($product_id, $quantity);

    if ($success) {
        // Log movement
        $stockMovement->log([
            'product_id' => $product_id,
            'user_id' => $user_id,
            'type' => 'out',
            'quantity' => $quantity,
            'reason' => $reason,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        Auth::setMessage("Stock reduced successfully!");
    } else {
        Auth::setMessage("Error: Not enough stock to remove.");
    }
}

// ✅ LOGIC TRANSFERRED: Supplier management logic copied from POS2 -> POS1
// ✳️ SOURCE: POS2 inventory.php supplier management section

// Handle add supplier
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_supplier'])) {
    $name = trim($_POST['name']);
    $contact_info = trim($_POST['contact_info']);
    if ($name) {
        $supplierModel->insert([
            'name' => $name,
            'contact_info' => $contact_info,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        Auth::setMessage('Supplier added!');
    }
}

// Handle delete supplier
if (isset($_GET['delete_supplier'])) {
    $id = (int)$_GET['delete_supplier'];
    $supplierModel->delete($id);
    Auth::setMessage('Supplier deleted!');
}

// Handle edit supplier (optional, for future inline/modal editing)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_supplier'])) {
    $id = (int)$_POST['supplier_id'];
    $name = trim($_POST['name']);
    $contact_info = trim($_POST['contact_info']);
    if ($name) {
        $supplierModel->update($id, [
            'name' => $name,
            'contact_info' => $contact_info
        ]);
        Auth::setMessage('Supplier updated!');
    }
}

// ✅ LOGIC TRANSFERRED: Data fetching logic copied from POS2 -> POS1
// ✳️ SOURCE: POS2 inventory.php data fetching section

// Fetch products and suppliers for the form
$products = $productModel->getAll(1000,0,'desc','id');
$suppliers = $supplierModel->getAll(1000,0,'desc','id');

// Fetch all suppliers for management tab
$all_suppliers = $supplierModel->getAll(1000,0,'desc','id');

// ✅ LOGIC TRANSFERRED: Audit trail and reports logic copied from POS2 -> POS1
// ✳️ SOURCE: POS2 inventory.php audit trail and reports section

// Fetch recent stock movements for audit trail
$audit_trail = $stockMovement->query("SELECT sm.*, p.description AS product_name, u.username AS user_name FROM stock_movements sm LEFT JOIN products p ON sm.product_id = p.id LEFT JOIN users u ON sm.user_id = u.id ORDER BY sm.created_at DESC LIMIT 20");

// Fetch low stock products for alerts
$low_stock = $inventory->query("SELECT i.*, p.description, p.sku, p.min_stock FROM inventory i JOIN products p ON i.product_id = p.id WHERE i.quantity < p.min_stock");

// ✅ INTEGRATION: Activated Stock History tab logic using POS2 structure
// ✳️ FIXED: Missing comprehensive inventory reports data in POS1

// Inventory Reports
// Current stock and valuation
$current_stock = $inventory->query("
    SELECT i.*, p.description, p.sku, p.cost_price, (i.quantity * p.cost_price) AS stock_value
    FROM inventory i
    JOIN products p ON i.product_id = p.id
");

// Stock movement history (last 30 days)
$stock_history = $stockMovement->query("
    SELECT sm.*, p.description AS product_name, u.username AS user_name
    FROM stock_movements sm
    LEFT JOIN products p ON sm.product_id = p.id
    LEFT JOIN users u ON sm.user_id = u.id
    WHERE sm.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    ORDER BY sm.created_at DESC
");

// Fast movers (top 5 most moved in last 30 days)
$fast_movers = $stockMovement->query("
    SELECT p.description, p.sku, SUM(sm.quantity) AS total_moved
    FROM stock_movements sm
    JOIN products p ON sm.product_id = p.id
    WHERE sm.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    GROUP BY sm.product_id
    ORDER BY total_moved DESC
    LIMIT 5
");

// Slow movers (top 5 least moved in last 30 days)
$slow_movers = $stockMovement->query("
    SELECT p.description, p.sku, SUM(sm.quantity) AS total_moved
    FROM stock_movements sm
    JOIN products p ON sm.product_id = p.id
    WHERE sm.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    GROUP BY sm.product_id
    ORDER BY total_moved ASC
    LIMIT 5
");

require views_path('inventory/inventory');
