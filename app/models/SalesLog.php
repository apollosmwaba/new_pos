<?php

class SalesLog extends Model
{
    protected $table = "sales_log";
    
    protected $allowed_columns = [
        'user_id',
        'sale_time',
        'total_amount',
        'details'
    ];

    public function log($user_id, $total_amount, $details) {
        return $this->insert([
            'user_id' => $user_id,
            'sale_time' => date('Y-m-d H:i:s'),
            'total_amount' => $total_amount,
            'details' => $details
        ]);
    }
} 