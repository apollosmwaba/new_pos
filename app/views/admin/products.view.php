<?php
// ✅ ADDED FROM POS2 - Products Catalog Display on 2024-12-19
// REASON: Added POS2 feature to POS1 for consistent modern UI experience
?>
<style>
.products-header {
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

.add-product-btn {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    border-radius: 12px;
    padding: 12px 25px;
    color: white;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.add-product-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    background: linear-gradient(135deg, #20c997, #17a2b8);
    color: white;
    text-decoration: none;
}

.products-table {
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

.product-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e9ecef;
}

.product-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.product-name {
    font-weight: 600;
    color: #2c3e50;
}

.product-description {
    color: #6c757d;
    font-size: 14px;
}

.product-price {
    color: #e74c3c;
    font-weight: 700;
    font-size: 18px;
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
    .products-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .add-product-btn {
        justify-content: center;
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

<div class="products-header">
    <h3 class="header-title">
        <i class="fa fa-hamburger"></i>
        Products Management
    </h3>
    <a href="index.php?pg=product-new" class="add-product-btn">
        <i class="fa fa-plus"></i>
        Add New Product
    </a>
</div>

<div class="products-table">
    <div class="table-header">
        <h4 class="table-title">
            <i class="fa fa-list"></i>
            All Products
        </h4>
    </div>
    
    <div class="table-container">
        <?php if($products): ?>
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Details</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $row): ?>
                        <tr>
                            <td>
                                <img src="<?=$row['image']?>" class="product-image" alt="<?=$row['description']?>">
                            </td>
                            <td>
                                <div class="product-info">
                                    <div class="product-name"><?=$row['description']?></div>
                                    <div class="product-description">ID: <?=$row['id']?></div>
                                </div>
                            </td>
                            <td>
                                <div class="product-price">$<?=$row['amount']?></div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="index.php?pg=product-edit&id=<?=$row['id']?>" class="btn-edit">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </a>
                                    <a href="index.php?pg=product-delete&id=<?=$row['id']?>" class="btn-delete">
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
                    <i class="fa fa-hamburger"></i>
                </div>
                <h4 class="empty-title">No Products Found</h4>
                <p class="empty-subtitle">Start by adding your first product to the menu</p>
                <a href="index.php?pg=product-new" class="add-product-btn">
                    <i class="fa fa-plus"></i>
                    Add Your First Product
                </a>
            </div>
        <?php endif; ?>
    </div>
</div> 