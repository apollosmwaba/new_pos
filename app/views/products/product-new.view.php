<?php require views_path('partials/header');?>

<div class="container-fluid border rounded p-4 m-2 col-lg-5 mx-auto">
    <form method="post" enctype="multipart/form-data">
        <h5 class="text-primary"><i class="fa fa-hamburger"></i> Add Product</h5>
        <div class="mb-3">
            <label class="form-label">Product Description</label>
            <input name="description" type="text" class="form-control <?=!empty($errors['description']) ? 'border-danger':''?>" placeholder="Product description" required>
            <?php if(!empty($errors['description'])):?>
                <small class="text-danger"><?=$errors['description']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Barcode <span class="text-muted small">(optional)</span></label>
            <input name="barcode" type="text" class="form-control <?=!empty($errors['barcode']) ? 'border-danger':''?>" placeholder="Product barcode">
            <?php if(!empty($errors['barcode'])):?>
                <small class="text-danger"><?=$errors['barcode']?></small>
            <?php endif;?>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Quantity</label>
                <input name="qty" type="number" class="form-control <?=!empty($errors['qty']) ? 'border-danger':''?>" min="1" value="1" required>
                <?php if(!empty($errors['qty'])):?>
                    <small class="text-danger"><?=$errors['qty']?></small>
                <?php endif;?>
            </div>
            <div class="col-md-6">
                <label class="form-label">Amount</label>
                <input name="amount" type="number" step="0.01" class="form-control <?=!empty($errors['amount']) ? 'border-danger':''?>" min="0" value="0.00" required>
                <?php if(!empty($errors['amount'])):?>
                    <small class="text-danger"><?=$errors['amount']?></small>
                <?php endif;?>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input name="image" type="file" class="form-control <?=!empty($errors['image']) ? 'border-danger':''?>" required>
            <?php if(!empty($errors['image'])):?>
                <small class="text-danger"><?=$errors['image']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">SKU</label>
            <input name="sku" type="text" class="form-control <?=!empty($errors['sku']) ? 'border-danger':''?>" placeholder="SKU">
            <?php if(!empty($errors['sku'])):?>
                <small class="text-danger"><?=$errors['sku']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input name="category" type="text" class="form-control <?=!empty($errors['category']) ? 'border-danger':''?>" placeholder="Category">
            <?php if(!empty($errors['category'])):?>
                <small class="text-danger"><?=$errors['category']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Supplier</label>
            <select name="supplier_id" class="form-control <?=!empty($errors['supplier_id']) ? 'border-danger':''?>">
                <option value="">Select Supplier</option>
                <?php if (!empty($suppliers)): ?>
                    <?php foreach($suppliers as $supplier): ?>
                        <option value="<?=$supplier['id']?>"><?=$supplier['name']?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php if(!empty($errors['supplier_id'])):?>
                <small class="text-danger"><?=$errors['supplier_id']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Minimum Stock</label>
            <input name="min_stock" type="number" class="form-control <?=!empty($errors['min_stock']) ? 'border-danger':''?>" placeholder="Minimum stock">
            <?php if(!empty($errors['min_stock'])):?>
                <small class="text-danger"><?=$errors['min_stock']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Cost Price</label>
            <input name="cost_price" type="number" step="0.01" class="form-control <?=!empty($errors['cost_price']) ? 'border-danger':''?>" placeholder="Cost price">
            <?php if(!empty($errors['cost_price'])):?>
                <small class="text-danger"><?=$errors['cost_price']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Selling Price</label>
            <input name="selling_price" type="number" step="0.01" class="form-control <?=!empty($errors['selling_price']) ? 'border-danger':''?>" placeholder="Selling price">
            <?php if(!empty($errors['selling_price'])):?>
                <small class="text-danger"><?=$errors['selling_price']?></small>
            <?php endif;?>
        </div>
        <button class="btn btn-danger float-end">Save</button>
        <a href="index.php?pg=admin&tab=products">
            <button type="button" class="btn btn-primary">Cancel</button>
        </a>
    </form>
</div>

<?php require views_path('partials/footer');?>