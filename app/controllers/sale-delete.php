<?php 

$errors = [];

$id = $_GET['id'] ?? null;
$sale = new Sale();

$row = $sale->first(['id'=>$id]);

if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
{
	
	$sale->delete($row['id']);
	// Audit log
	$db = new Database();
	$db->query(
		"INSERT INTO audit_log (user_id, action_type, action_time, description, related_sale_id) VALUES (:user_id, :action_type, :action_time, :description, :related_sale_id)",
		[
			'user_id' => auth('id'),
			'action_type' => 'delete',
			'action_time' => date('Y-m-d H:i:s'),
			'description' => 'Deleted sale ID: ' . $row['id'],
			'related_sale_id' => $row['id']
		]
	);
  
	redirect('admin&tab=sales');
 

}


require views_path('sales/sale-delete');

