<?php require views_path('partials/header');?>

<div class="container-fluid border rounded p-4 m-2 col-lg-5 mx-auto">
    <?php if(!empty($row)):?>
    <form method="post">
        <h5 class="text-primary"><i class="fa fa-hamburger"></i> Edit Product</h5>
        <div class="mb-3">
            <label class="form-label">Product Description</label>
            <input value="<?=set_value('description',$row['description'])?>" name="description" type="text" class="form-control <?=!empty($errors['description']) ? 'border-danger':''?>" placeholder="Product description">
            <?php if(!empty($errors['description'])):?>
                <small class="text-danger"><?=$errors['description']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">SKU</label>
            <input value="<?=set_value('sku',$row['sku'])?>" name="sku" type="text" class="form-control <?=!empty($errors['sku']) ? 'border-danger':''?>" placeholder="SKU">
            <?php if(!empty($errors['sku'])):?>
                <small class="text-danger"><?=$errors['sku']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input value="<?=set_value('category',$row['category'])?>" name="category" type="text" class="form-control <?=!empty($errors['category']) ? 'border-danger':''?>" placeholder="Category">
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
                        <option value="<?=$supplier['id']?>" <?=set_value('supplier_id',$row['supplier_id'])==$supplier['id']?'selected':''?>><?=$supplier['name']?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php if(!empty($errors['supplier_id'])):?>
                <small class="text-danger"><?=$errors['supplier_id']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Minimum Stock</label>
            <input value="<?=set_value('min_stock',$row['min_stock'])?>" name="min_stock" type="number" class="form-control <?=!empty($errors['min_stock']) ? 'border-danger':''?>" placeholder="Minimum stock">
            <?php if(!empty($errors['min_stock'])):?>
                <small class="text-danger"><?=$errors['min_stock']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Cost Price</label>
            <input value="<?=set_value('cost_price',$row['cost_price'])?>" name="cost_price" type="number" step="0.01" class="form-control <?=!empty($errors['cost_price']) ? 'border-danger':''?>" placeholder="Cost price">
            <?php if(!empty($errors['cost_price'])):?>
                <small class="text-danger"><?=$errors['cost_price']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Selling Price</label>
            <input value="<?=set_value('selling_price',$row['selling_price'])?>" name="selling_price" type="number" step="0.01" class="form-control <?=!empty($errors['selling_price']) ? 'border-danger':''?>" placeholder="Selling price">
            <?php if(!empty($errors['selling_price'])):?>
                <small class="text-danger"><?=$errors['selling_price']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Discount Type</label>
            <select name="discount_type" class="form-control">
                <option value="">None</option>
                <option value="percent" <?=set_value('discount_type',$row['discount_type'])=='percent'?'selected':''?>>Percent (%)</option>
                <option value="fixed" <?=set_value('discount_type',$row['discount_type'])=='fixed'?'selected':''?>>Fixed Amount</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Discount Value</label>
            <input value="<?=set_value('discount_value',$row['discount_value'])?>" name="discount_value" type="number" step="0.01" class="form-control" placeholder="Discount value">
        </div>
        <div class="mb-3">
            <label class="form-label">Promotion Text</label>
            <input value="<?=set_value('promo_text',$row['promo_text'])?>" name="promo_text" type="text" class="form-control" placeholder="Promo text (e.g. '20% OFF!')">
        </div>
        <button class="btn btn-danger float-end">Save</button>
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