<?php 

$errors = [];

$id = $_GET['id'] ?? null;
$product = new Product();

$row = $product->first(['id'=>$id]);

if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
{

	$_POST['barcode'] = empty($_POST['barcode']) ? $product->generate_barcode():$_POST['barcode'];
	
	if(!empty($_FILES['image']['name']))
	{
		$_POST['image'] = $_FILES['image'];
	}

	$errors = $product->validate($_POST,$row['id']);
	if(empty($errors)){
		
		$folder = "uploads/";
		if(!file_exists($folder))
		{
			mkdir($folder,0777,true);
		}

		if(!empty($_POST['image']))
		{

			$ext = strtolower(pathinfo($_POST['image']['name'],PATHINFO_EXTENSION));

			$destination = $folder . $product->generate_filename($ext);
			move_uploaded_file($_POST['image']['tmp_name'], $destination);
			$_POST['image'] = $destination;

			//delete old image
			if(file_exists($row['image']))
			{
				unlink($row['image']);
			}
		
		}

		$product->update($row['id'],$_POST);

		// Update inventory quantity if changed
		require_once "../app/models/Inventory.php";
		$inventory = new Inventory();
		$inventory_row = $inventory->getByProduct($row['id']);
		if ($inventory_row) {
			$inventory->update($inventory_row['id'], [
				'quantity' => $_POST['qty'] ?? $inventory_row['quantity'],
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

require views_path('products/product-edit');

