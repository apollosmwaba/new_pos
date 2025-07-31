<?php 

$tab = $_GET['tab'] ?? 'dashboard';


if($tab == "products")
{

	$productClass = new Product();
	$products = $productClass->query("select * from products");
	// $products = $productClass->findAll();
	// $products = $productClass->query("SELECT * FROM products ORDER BY date DESC", [], 1000);
	//  echo "Products fetched: " . count($products);
    // print_r($products);
}else
if($tab == "sales")
{
	
	$section = $_GET['s'] ?? 'table';
	$startdate = $_GET['start'] ?? null;
	$enddate = $_GET['end'] ?? null;


	$saleClass = new Sale();
	$userClass = new User();
	$productClass = new Product();
	
	$limit = $_GET['limit'] ?? 20;
	$limit = (int)$limit;
	$limit = $limit < 1 ? 10 : $limit;

	$pager = new Pager($limit);
	$offset = $pager->offset;

	// ✅ LOGIC TRANSFERRED: Sales grouping logic copied from POS2 -> POS1
	// ✳️ SOURCE: POS2 admin.php sales section
	
	// Group sales by receipt_no (one row per transaction)
	$query = "SELECT MIN(id) as id, receipt_no, MAX(date) as date, SUM(total) as total, user_id FROM sales ";
	$where = [];
	if($startdate && $enddate) {
		$where[] = "date BETWEEN '$startdate' AND '$enddate'";
	} else if($startdate && !$enddate) {
		$where[] = "date = '$startdate'";
	}
	if ($where) {
		$query .= "WHERE ".implode(' AND ', $where)." ";
	}
	$query .= "GROUP BY receipt_no ORDER BY id DESC LIMIT $limit OFFSET $offset";

	$sales = $saleClass->query($query);

	// ✅ LOGIC TRANSFERRED: Enhanced sales data with products and admin info copied from POS2 -> POS1
	// ✳️ SOURCE: POS2 admin.php sales section
	
	// Attach products and admin info for each sale (receipt_no)
	if ($sales && is_array($sales)) {
		foreach ($sales as &$sale) {
			$receipt_no = $sale['receipt_no'];
			$items = $saleClass->query("SELECT description FROM sales WHERE receipt_no = ?", [$receipt_no]);
			$sale['products'] = $items ? array_column($items, 'description') : [];
			// Get admin name
			$admin = $userClass->query("SELECT username FROM users WHERE id = ?", [$sale['user_id']]);
			$sale['admin_name'] = $admin && isset($admin[0]['username']) ? $admin[0]['username'] : 'N/A';
		}
		unset($sale);
	} else {
		$sales = [];
	}

	// ✅ LOGIC TRANSFERRED: Enhanced sales statistics calculation copied from POS2 -> POS1
	// ✳️ SOURCE: POS2 admin.php sales section
	
	// Total revenue (all time)
	$query_total_revenue = "SELECT SUM(total) as total FROM sales";
	// Total sales (all time, by receipt_no)
	$query_total_sales = "SELECT COUNT(DISTINCT receipt_no) as total FROM sales";
	// Today's sales count (by receipt_no)
	$today = date('Y-m-d');
	$query_today_sales = "SELECT COUNT(DISTINCT receipt_no) as total FROM sales WHERE DATE(date) = '$today'";

	$st_revenue = $saleClass->query($query_total_revenue);
	$st_sales = $saleClass->query($query_total_sales);
	$st_today = $saleClass->query($query_today_sales);

	$total_revenue = $st_revenue ? $st_revenue[0]['total'] ?? 0 : 0;
	$total_sales = $st_sales ? $st_sales[0]['total'] ?? 0 : 0;
	$today_sales = $st_today ? $st_today[0]['total'] ?? 0 : 0;

	if($section == 'graph')
	{
		// ✅ LOGIC TRANSFERRED: Sales Graph logic copied from POS2 -> POS1
		// ✳️ SOURCE: POS2 admin.php graph section
		
		//read graph data
		$db = new Database();

		//query todays records
		$today = date('Y-m-d');
		$query = "SELECT total,date FROM sales WHERE DATE(date) = '$today' ";
		$today_records = $db->query($query);

		//query this months records
		$thismonth = date('m');
		$thisyear = date('Y');

		$query = "SELECT total,date FROM sales WHERE month(date) = '$thismonth' && year(date) = '$thisyear'";
		$thismonth_records = $db->query($query);

		//query this years records
		$query = "SELECT total,date FROM sales WHERE year(date) = '$thisyear'";
		$thisyear_records = $db->query($query);

		// ✅ LOGIC TRANSFERRED: Enhanced graph data generation copied from POS2 -> POS1
		// ✳️ SOURCE: POS2 admin.php sales graph section
		
		// Sales graph data
		$graph_period = $_GET['graph_period'] ?? 'day'; // default to day
		$graph_data = [];
		if ($graph_period === 'day') {
			// Sales for today, grouped by hour
			$today = date('Y-m-d');
			$query_graph = "SELECT HOUR(date) as label, SUM(total) as total FROM sales WHERE DATE(date) = '$today' GROUP BY HOUR(date) ORDER BY label";
			$result = $saleClass->query($query_graph);
			
			if($result && count($result) > 0) {
				foreach ($result as $row) {
					$graph_data[] = [
						'label' => $row['label'] . ':00',
						'total' => (float)$row['total']
					];
				}
			}
		} elseif ($graph_period === 'month') {
			// Sales for this month, grouped by day
			$thismonth = date('m');
			$thisyear = date('Y');
			$query_graph = "SELECT DAY(date) as label, SUM(total) as total FROM sales WHERE MONTH(date) = '$thismonth' AND YEAR(date) = '$thisyear' GROUP BY DAY(date) ORDER BY label";
			$result = $saleClass->query($query_graph);
			if($result && count($result) > 0) {
				foreach ($result as $row) {
					$graph_data[] = [
						'label' => 'Day ' . $row['label'],
						'total' => (float)$row['total']
					];
				}
			}
		} elseif ($graph_period === 'year') {
			// Sales for this year, grouped by month
			$thisyear = date('Y');
			$query_graph = "SELECT MONTH(date) as label, SUM(total) as total FROM sales WHERE YEAR(date) = '$thisyear' GROUP BY MONTH(date) ORDER BY label";
			$result = $saleClass->query($query_graph);
			if($result && count($result) > 0) {
				foreach ($result as $row) {
					$graph_data[] = [
						'label' => date('M', mktime(0, 0, 0, $row['label'], 10)),
						'total' => (float)$row['total']
					];
				}
			}
		}
	}

}else
if($tab == "users")
{

	$limit = 10;
	$pager = new Pager($limit);
	$offset = $pager->offset;

	$userClass = new User();
	$users = $userClass->query("select * from users order by id desc limit $limit offset $offset");
}else
if($tab == "graph")
{
	// ✅ LOGIC TRANSFERRED: Standalone Graph tab logic copied from POS2 -> POS1
	// ✳️ SOURCE: POS2 admin.php graph tab section
	
	$saleClass = new Sale();
	$graph_period = $_GET['graph_period'] ?? 'day'; // default to day
	$graph_data = [];
	if ($graph_period === 'day') {
		$today = date('Y-m-d');
		$query_graph = "SELECT HOUR(date) as label, SUM(total) as total FROM sales WHERE DATE(date) = '$today' GROUP BY HOUR(date) ORDER BY label";
		$result = $saleClass->query($query_graph);
		
		if ($result && count($result) > 0){
			foreach ($result as $row) {
				$graph_data[] = [
					'label' => $row['label'] . ':00',
					'total' => (float)$row['total']
				];
			}
		}
	} elseif ($graph_period === 'month') {
		$thismonth = date('m');
		$thisyear = date('Y');
		$query_graph = "SELECT DAY(date) as label, SUM(total) as total FROM sales WHERE MONTH(date) = '$thismonth' AND YEAR(date) = '$thisyear' GROUP BY DAY(date) ORDER BY label";
		$result = $saleClass->query($query_graph);
		
		if ($result && count($result) > 0) {
			foreach ($result as $row) {
				$graph_data[] = [
					'label' => 'Day ' . $row['label'],
					'total' => (float)$row['total']
				];
			}
		}
	} elseif ($graph_period === 'year') {
		$thisyear = date('Y');
		$query_graph = "SELECT MONTH(date) as label, SUM(total) as total FROM sales WHERE YEAR(date) = '$thisyear' GROUP BY MONTH(date) ORDER BY label";
		$result = $saleClass->query($query_graph);
		
		if ($result && count($result) > 0){
			foreach ($result as $row) {
				$graph_data[] = [
					'label' => date('M', mktime(0, 0, 0, $row['label'], 10)),
					'total' => (float)$row['total']
				];
			}
		} else { 
			echo "No sales Yet "; 
		}
	}
}else
if($tab == "dashboard")
{

	$db = new Database();
	$query = "select count(id) as total from users";

	$myusers = $db->query($query);
	$total_users = $myusers[0]['total'];

	$query = "select count(id) as total from products";

	$myproducts = $db->query($query);
	$total_products = $myproducts[0]['total'];

	$query = "select sum(total) as total from sales";

	$mysales = $db->query($query);
	$total_sales = $mysales[0]['total'];

	
}else
if($tab == "register")
{
    $db = new Database();
    $session_logs = $db->query("SELECT * FROM session_log ORDER BY id DESC LIMIT 100");
    // Fetch recent sales for Register tab
    $sales = $db->query("SELECT s.*, u.username as admin FROM sales s LEFT JOIN users u ON s.user_id = u.id ORDER BY s.id DESC LIMIT 20");

    $audit_logs = $db->query("SELECT * FROM audit_log ORDER BY id DESC LIMIT 100");
    // require views_path('admin/register'); // Removed to prevent duplicate rendering. Only render in admin dashboard view.
}


if(Auth::access('supervisor')){
	require views_path('admin/admin');
}else{

	Auth::setMessage("You dont have access to the admin page");
	require views_path('auth/denied');
}

