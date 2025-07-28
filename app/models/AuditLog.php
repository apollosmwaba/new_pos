<?php

class AuditLog extends Model
{
    protected $table = "audit_log";
    
    protected $allowed_columns = [
        'user_id',
        'action_type',
        'action_time',
        'description',
        'related_sale_id'
    ];

    public function log($user_id, $action_type, $description, $related_sale_id = null) {
        return $this->insert([
            'user_id' => $user_id,
            'action_type' => $action_type,
            'action_time' => date('Y-m-d H:i:s'),
            'description' => $description,
            'related_sale_id' => $related_sale_id
        ]);
    }
} 