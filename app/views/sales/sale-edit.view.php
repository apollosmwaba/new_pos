<?php require views_path('partials/header');?>
<div class="container-fluid border rounded p-4 m-2 col-lg-5 mx-auto">
    <?php if(!empty($row)):?>
    <form method="post">
        <h5 class="text-primary"><i class="fa fa-money-bill-wave"></i> Edit Sale</h5>
        <div class="mb-3">
            <label class="form-label">Receipt No</label>
            <input value="<?=set_value('receipt_no',$row['receipt_no'])?>" name="receipt_no" type="text" class="form-control <?=!empty($errors['receipt_no']) ? 'border-danger':''?>" placeholder="Receipt No">
            <?php if(!empty($errors['receipt_no'])):?>
                <small class="text-danger"><?=$errors['receipt_no']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input value="<?=set_value('date',$row['date'])?>" name="date" type="date" class="form-control <?=!empty($errors['date']) ? 'border-danger':''?>">
            <?php if(!empty($errors['date'])):?>
                <small class="text-danger"><?=$errors['date']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Products (comma separated)</label>
            <input value="<?=set_value('products', isset($row['products']) ? implode(',', $row['products']) : '')?>" name="products" type="text" class="form-control <?=!empty($errors['products']) ? 'border-danger':''?>" placeholder="Product1,Product2,Product3">
            <?php if(!empty($errors['products'])):?>
                <small class="text-danger"><?=$errors['products']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Total</label>
            <input value="<?=set_value('total',$row['total'])?>" name="total" type="number" step="0.01" class="form-control <?=!empty($errors['total']) ? 'border-danger':''?>" placeholder="Total">
            <?php if(!empty($errors['total'])):?>
                <small class="text-danger"><?=$errors['total']?></small>
            <?php endif;?>
        </div>
        <div class="mb-3">
            <label class="form-label">Admin Name</label>
            <input value="<?=set_value('admin_name',$row['admin_name'])?>" name="admin_name" type="text" class="form-control <?=!empty($errors['admin_name']) ? 'border-danger':''?>" placeholder="Admin Name">
            <?php if(!empty($errors['admin_name'])):?>
                <small class="text-danger"><?=$errors['admin_name']?></small>
            <?php endif;?>
        </div>
        <button class="btn btn-primary float-end">Save</button>
        <a href="index.php?pg=admin&tab=sales">
            <button type="button" class="btn btn-danger">Cancel</button>
        </a>
    </form>
    <?php else:?>
        That record was not found
        <br><br>
        <a href="index.php?pg=admin&tab=sales">
            <button type="button" class="btn btn-primary">Back to sales</button>
        </a>
    <?php endif;?>
</div>
<?php require views_path('partials/footer');?>