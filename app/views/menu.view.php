<?php require views_path('partials/header'); ?>

<div class="container py-5">
    <h2 class="mb-4 text-center"><i class="fa fa-utensils"></i> Menu</h2>
    <div class="row g-4">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <?php
                            // Determine the correct image path as in home page
                            $img = '/POS/Point-of-sale-1/public/assets/images/no_image.jpg';
                            if (!empty($product['image'])) {
                                if (strpos($product['image'], 'uploads/') === 0 || strpos($product['image'], '/uploads/') === 0) {
                                    $img = '/POS/Point-of-sale-1/public/' . ltrim($product['image'], '/');
                                } else {
                                    $img = '/POS/Point-of-sale-1/public/uploads/' . $product['image'];
                                }
                            }
                        ?>
                        <img src="<?=$img?>" class="w-100 rounded border" alt="<?=esc($product['description'])?>" style="height:180px;object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2"><?=esc($product['description'])?></h5>
                            <?php if (!empty($product['promo_text'])): ?>
                                <div class="alert alert-success p-1 text-center mb-2"><strong><?=esc($product['promo_text'])?></strong></div>
                            <?php endif; ?>
                            <?php
                                $price = (isset($product['selling_price']) && $product['selling_price'] > 0)
    ? (float)$product['selling_price']
    : (isset($product['amount']) ? (float)$product['amount'] : 0);
                                $discounted = false;
                                $final_price = $price;
                                if (!empty($product['discount_type']) && $product['discount_value'] > 0) {
                                    if ($product['discount_type'] === 'percent') {
                                        $discount = $price * ($product['discount_value'] / 100);
                                        $final_price = $price - $discount;
                                        $discounted = true;
                                    } elseif ($product['discount_type'] === 'fixed') {
                                        $final_price = $price - $product['discount_value'];
                                        $discounted = true;
                                    }
                                }
                            ?>
                            <p class="card-text mb-1">
                                <strong>Price:</strong>
                                <?php if ($discounted && $final_price != $price): ?>
                                    <span style="text-decoration:line-through;color:#888;">K<?=number_format($price,2)?></span>
                                    <span class="text-danger fw-bold ms-2">K<?=number_format($final_price,2)?></span>
                                <?php else: ?>
                                    K<?=number_format($price,2)?>
                                <?php endif; ?>
                            </p>
                            <p class="card-text mb-2"><strong>Available:</strong> <?=isset($product['qty']) ? esc($product['qty']) : 'N/A'?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">No products available.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require views_path('partials/footer'); ?> 