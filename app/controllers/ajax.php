<?php 

defined("ABSPATH") ? "":die();

//capture ajax data
$raw_data = file_get_contents("php://input");
if(!empty($raw_data))
{

	$OBJ = json_decode($raw_data,true);
	if(is_array($OBJ))
	{
		if($OBJ['data_type'] == "search")
		{

			$productClass = new Product();
			$limit = 20;

			if(!empty($OBJ['text']))
			{
				//search
				$barcode = $OBJ['text'];
				$text = "%".$OBJ['text']."%";
				$query = "select * from products where description like :find || barcode = :barcode order by views desc limit $limit";
				$rows = $productClass->query($query,['find'=>$text,'barcode'=>$barcode]);

			}else{
				//get all
				//$limit = 10,$offset = 0,$order = "desc",$order_column = "id"
				$rows = $productClass->getAll($limit,0,'desc','views');
			}
			
			if($rows){

				foreach ($rows as $key => $row) {
    $rows[$key]['description'] = strtoupper($row['description']);
    $rows[$key]['image'] = crop($row['image']);
    // Discount calculation
    $price = isset($row['selling_price']) && $row['selling_price'] > 0 ? (float)$row['selling_price'] : (float)$row['amount'];
    $final_price = $price;
    $has_discount = false;
    if (!empty($row['discount_type']) && $row['discount_value'] > 0) {
        if ($row['discount_type'] === 'percent') {
            $discount = $price * ((float)$row['discount_value'] / 100);
            $final_price = $price - $discount;
            $has_discount = true;
        } elseif ($row['discount_type'] === 'fixed') {
            $final_price = $price - (float)$row['discount_value'];
            $has_discount = true;
        }
    }
    $rows[$key]['has_discount'] = $has_discount;
    $rows[$key]['discounted_price'] = $has_discount ? number_format($final_price, 2, '.', '') : null;
    $rows[$key]['amount'] = number_format($price, 2, '.', '');
}

				$info['data_type'] = "search";
				$info['data'] = $rows;
				
				echo json_encode($info);

			}

		}else
		if($OBJ['data_type'] == "checkout")
		{

			$data 		= $OBJ['text'];
			$receipt_no 	= get_receipt_no();
			$user_id 	= auth("id");
			$date 		= date("Y-m-d H:i:s");
			$db = new Database();
			$total_amount = 0;
			$details = [];
			//read from database
			foreach ($data as $row) {
				$arr = [];
				$arr['id'] = $row['id'];
				$query = "select * from products where id = :id limit 1";
				$check = $db->query($query,$arr);
				if(is_array($check))
				{
					$check = $check[0];
					//save to database
					$arr = [];
					$arr['barcode']     = $check['barcode'];
					$arr['description'] = $check['description'];
					$arr['amount']      = $check['amount'];
					$arr['qty']         = $row['qty'];
					$arr['total']       = $row['qty'] * $check['amount'];
					$arr['receipt_no']  = $receipt_no;
					$arr['date']        = $date;
					$arr['user_id']     = $user_id;
					$query = "insert into sales (barcode,receipt_no,description,qty,amount,total,date,user_id) values (:barcode,:receipt_no,:description,:qty,:amount,:total,:date,:user_id)";
					$db->query($query,$arr);
					$total_amount += $arr['total'];
					$details[] = [
						'description' => $arr['description'],
						'qty' => $arr['qty'],
						'amount' => $arr['amount'],
						'total' => $arr['total']
					];
					//add view count for this product
					$query = "update products set views = views + 1 where id = :id limit 1";
					$db->query($query,['id'=>$check['id']]);
					$query = "update products set views = views + 1 where id = :id limit 1";
					$db->query($query,['id'=>$check['id']]);
				}
			}
			// Log to sales_log
			try {
				$result = $db->query(
					"INSERT INTO sales_log (user_id, sale_time, total_amount, details) VALUES (:user_id, :sale_time, :total_amount, :details)",
					[
						'user_id' => $user_id,
						'sale_time' => $date,
						'total_amount' => $total_amount,
						'details' => json_encode($details)
					]
				);
				if ($result === false) {
					error_log('Failed to insert into sales_log.');
					echo json_encode(['error' => 'Failed to insert into sales_log.']);
					exit;
				}
			} catch (Exception $e) {
				error_log('Exception inserting into sales_log: ' . $e->getMessage());
				echo json_encode(['error' => 'Exception inserting into sales_log: ' . $e->getMessage()]);
				exit;
			}
			$info['data_type'] = "checkout";
			$info['data'] = "items saved successfully!";
			echo json_encode($info);
		}

	}

}
