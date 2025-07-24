<?php 

$errors = [];

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$user = new User();
 	if($row = $user->where(['email'=>$_POST['email']]))
 	{
  	 
 		if(password_verify($_POST['password'], $row[0]['password']))
 		{
 			authenticate($row[0]);
			// Log session start
			$db = new Database();
			$db->query(
				"INSERT INTO session_log (user_id, role, login_time) VALUES (:user_id, :role, :login_time)",
				[
					'user_id' => $row[0]['id'],
					'role' => $row[0]['role'],
					'login_time' => date('Y-m-d H:i:s')
				]
			);
			redirect('home');
 		}else
	 	{
	 		$errors['password'] = "wrong password";
	 	}
 	}else
 	{
 		$errors['email'] = "wrong email";
 	}


}

require views_path('auth/login');

