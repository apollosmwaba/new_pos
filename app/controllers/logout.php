<?php 


if(isset($_SESSION['USER'])){
    // Log session end
    $db = new Database();
    $user_id = $_SESSION['USER']['id'];
    // Get the latest session for this user
    $session = $db->query("SELECT * FROM session_log WHERE user_id = :user_id ORDER BY id DESC LIMIT 1", ['user_id' => $user_id]);
    if ($session) {
        $login_time = strtotime($session[0]['login_time']);
        $logout_time = time();
        $duration = $logout_time - $login_time;
        $db->query(
            "UPDATE session_log SET logout_time = :logout_time, session_duration = :duration WHERE id = :id",
            [
                'logout_time' => date('Y-m-d H:i:s', $logout_time),
                'duration' => $duration,
                'id' => $session[0]['id']
            ]
        );
    }
    unset($_SESSION['USER']);
}

//session_destroy();
//session_regenerate_id();

redirect('login');