<?php
require_once __DIR__ . '/../core/init.php'; 
require_once __DIR__ . '/../models/Auth.php';

session_start();

// Use Auth class for admin check
if (!Auth::access('admin')) {
    $_SESSION['MESSAGE'] = 'Unauthorized access.';
    header('Location: ../index.php');
    exit;
}

$db = new Database();
$db->query("DELETE FROM sales"); 
// If you have a sales_log table, clear it too:
$db->query("DELETE FROM sales_log");
// If you have a sale_products or related table, clear it as well:
// $db->query("DELETE FROM sale_products");

$_SESSION['MESSAGE'] = "All sales logs have been erased.";
header('Location: /p1/public/index.php?pg=admin&tab=register'); 

exit;
