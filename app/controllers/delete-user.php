<?php 

$errors = [];
$user = new User();

$id = $_GET['id'] ?? null;
$row = $user->first(['id'=>$id]);

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	if(is_array($row) && Auth::access('admin') && $row['deletable'])
	{
		$user->delete($id);
		// Audit log
		$db = new Database();
		$db->query(
			"INSERT INTO audit_log (user_id, action_type, action_time, description, related_sale_id) VALUES (:user_id, :action_type, :action_time, :description, :related_sale_id)",
			[
				'user_id' => auth('id'),
				'action_type' => 'delete',
				'action_time' => date('Y-m-d H:i:s'),
				'description' => 'Deleted user: ' . $row['username'],
				'related_sale_id' => null
			]
		);
		redirect('admin&tab=users');
	}

}
	
if(Auth::access('admin')){
	require views_path('auth/delete-user');
}else{

	Auth::setMessage("Only admins can delete users");
	require views_path('auth/denied');
}

