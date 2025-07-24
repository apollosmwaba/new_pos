<?php require views_path('partials/header');?>
<div class="container-fluid border rounded p-4 m-2 col-lg-5 mx-auto">
    <?php if(!empty($row)):?>
    <form method="post">
        <h5 class="text-primary"><i class="fa fa-hamburger"></i> Delete Product</h5>
        <div class="alert alert-danger text-center">Are you sure you want to delete this product?</div>
        <div class="mb-3">
            <label class="form-label">Product Description</label>
            <div class="form-control"><?=htmlspecialchars($row['description'])?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">SKU</label>
            <div class="form-control"><?=htmlspecialchars($row['sku'])?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <div class="form-control"><?=htmlspecialchars($row['category'])?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Supplier</label>
            <div class="form-control">
                <?php if (!empty($suppliers)): ?>
                    <?php foreach($suppliers as $supplier): ?>
                        <?php if($supplier['id'] == $row['supplier_id']) echo htmlspecialchars($supplier['name']); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Minimum Stock</label>
            <div class="form-control"><?=htmlspecialchars($row['min_stock'])?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Cost Price</label>
            <div class="form-control"><?=htmlspecialchars($row['cost_price'])?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Selling Price</label>
            <div class="form-control"><?=htmlspecialchars($row['selling_price'])?></div>
        </div>
        <button class="btn btn-danger float-end">Delete</button>
        <a href="index.php?pg=admin&tab=products">
            <button type="button" class="btn btn-primary">Cancel</button>
        </a>
    </form>
    <?php else:?>
        That product was not found
        <br><br>
        <a href="index.php?pg=admin&tab=products">
            <button type="button" class="btn btn-primary">Back to products</button>
        </a>
    <?php endif;?>
</div>
<?php require views_path('partials/footer');?>