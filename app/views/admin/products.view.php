<div class="admin-table-container">
    <div class="table-header">
        <h4><i class="fa fa-hamburger me-2"></i>Products</h4>
        <a href="index.php?pg=product-new" class="btn btn-primary"><i class="fa fa-plus"></i> Add Product</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Cost Price</th>
                    <th>Selling Price</th>
                    <th>Min Stock</th>
                    <th>Date Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?=htmlspecialchars($product['id'])?></td>
                            <td><?=htmlspecialchars($product['description'])?></td>
                            <td><?=htmlspecialchars($product['sku'])?></td>
                            <td><?=htmlspecialchars($product['category'])?></td>
                            <td><?=htmlspecialchars($product['cost_price'])?></td>
                            <td><?=htmlspecialchars($product['selling_price'])?></td>
                            <td><?=htmlspecialchars($product['min_stock'])?></td>
                            <td><?=htmlspecialchars($product['date'])?></td>
                            <td>
                                <a href="index.php?pg=product-edit&id=<?=$product['id']?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                                <a href="index.php?pg=product-delete&id=<?=$product['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div> 