<?php

class SessionLog extends Model
{
    protected $table = "session_log";
    
    protected $allowed_columns = [
        'user_id',
        'role',
        'login_time',
        'logout_time',
        'session_duration'
    ];

    public function logLogin($user_id, $role) {
        return $this->insert([
            'user_id' => $user_id,
            'role' => $role,
            'login_time' => date('Y-m-d H:i:s')
        ]);
    }

    public function logLogout($user_id) {
        $session = $this->first(['user_id' => $user_id, 'logout_time' => null]);
        if ($session) {
            $logout_time = date('Y-m-d H:i:s');
            $duration = strtotime($logout_time) - strtotime($session['login_time']);
            return $this->update($session['id'], [
                'logout_time' => $logout_time,
                'session_duration' => $duration
            ]);
        }
        return false;
    }
} 