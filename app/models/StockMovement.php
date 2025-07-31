<?php

class StockMovement extends Model
{
    protected $table = "stock_movements";
    
    protected $allowed_columns = [
        'product_id',
        'type',
        'qty',
        'user_id',
        'reason',
        'supplier_id',
        'cost',
        'created_at'
    ];

    public function validate($data)
    {
        $errors = [];

        if(empty($data['product_id']))
            $errors['product_id'] = "Product ID is required";

        if(empty($data['qty']))
            $errors['qty'] = "Quantity is required";
        
        if(empty($data['type']))
            $errors['type'] = "Movement type is required";

        return $errors;
    }

    public function log($data) {
        $this->insert($data);
    }
}