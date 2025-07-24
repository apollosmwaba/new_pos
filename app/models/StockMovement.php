<?php

class StockMovement extends Model
{
    protected $table = "stock_movements";

    public function log($data) {
        $this->insert($data);
    }
}