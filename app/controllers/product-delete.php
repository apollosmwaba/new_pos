<?php 

$errors = [];

$id = $_GET['id'] ?? null;
$product = new Product();

$row = $product->first(['id'=>$id]);

if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
{
	
	$product->delete($row['id']);
	// Audit log
	$db = new Database();
	$db->query(
		"INSERT INTO audit_log (user_id, action_type, action_time, description, related_sale_id) VALUES (:user_id, :action_type, :action_time, :description, :related_sale_id)",
		[
			'user_id' => auth('id'),
			'action_type' => 'delete',
			'action_time' => date('Y-m-d H:i:s'),
			'description' => 'Deleted product: ' . $row['description'],
			'related_sale_id' => null
		]
	);
  	
	//delete old image
	if(file_exists($row['image']))
	{
		unlink($row['image']);
	}

	redirect('admin&tab=products');
 

}


require views_path('products/product-delete');

