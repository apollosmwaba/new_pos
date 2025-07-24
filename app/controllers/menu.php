<?php
require_once __DIR__ . '/../models/Product.php';

$productClass = new Product();
$products = $productClass->query('SELECT * FROM products');

require views_path('menu'); 