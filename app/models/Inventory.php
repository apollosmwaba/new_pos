<?php

class Inventory extends Model
{
    protected $table = "inventory";

    // Get inventory for a product
    public function getByProduct($product_id) {
        return $this->first(['product_id' => $product_id]);
    }

    // Increase stock (stock in)
    public function stockIn($product_id, $quantity) {
        $current = $this->getByProduct($product_id);
        if ($current) {
            $new_qty = $current['quantity'] + $quantity;
            $this->update($current['id'], ['quantity' => $new_qty, 'updated_at' => date('Y-m-d H:i:s')]);
        } else {
            $this->insert(['product_id' => $product_id, 'quantity' => $quantity, 'updated_at' => date('Y-m-d H:i:s')]);
        }
    }

    // Decrease stock (stock out)
    public function stockOut($product_id, $quantity) {
        $current = $this->getByProduct($product_id);
        if ($current && $current['quantity'] >= $quantity) {
            $new_qty = $current['quantity'] - $quantity;
            $this->update($current['id'], ['quantity' => $new_qty, 'updated_at' => date('Y-m-d H:i:s')]);
            return true;
        }
        return false;
    }
}
