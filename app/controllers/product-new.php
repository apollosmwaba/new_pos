<?php 

$errors = [];

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$product = new Product();

	$_POST['date'] = date("Y-m-d H:i:s");
	$_POST['user_id'] = auth("id");
	$_POST['barcode'] = empty($_POST['barcode']) ? $product->generate_barcode():$_POST['barcode'];
	
	if(!empty($_FILES['image']['name']))
	{
		$_POST['image'] = $_FILES['image'];
	}

	$errors = $product->validate($_POST);
	if(empty($errors)){
		
		$folder = "uploads/";
		if(!file_exists($folder))
		{
			mkdir($folder,0777,true);
		}

		$ext = strtolower(pathinfo($_POST['image']['name'],PATHINFO_EXTENSION));

		$destination = $folder . $product->generate_filename($ext);
		move_uploaded_file($_POST['image']['tmp_name'], $destination);
		$_POST['image'] = $destination;

		$product_id = $product->insert($_POST);

		// Add inventory record for new product
		if ($product_id) {
			require_once "../app/models/Inventory.php";
			$inventory = new Inventory();
			$inventory->insert([
				'product_id' => $product_id,
				'quantity' => $_POST['qty'],
				'updated_at' => date('Y-m-d H:i:s')
			]);
		}

		redirect('admin&tab=products');
	}


}

// Fetch suppliers for the dropdown
require_once "../app/models/Supplier.php";
$supplierModel = new Supplier();
$suppliers = $supplierModel->getAll(1000,0,'desc','id');

require views_path('products/product-new');

