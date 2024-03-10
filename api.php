<?php
include 'db.php';

$request_method = $_SERVER["REQUEST_METHOD"];
$endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : '';

switch ($endpoint) {
    case 'products':
        include 'Ecommerce.php';
        break;
    case 'order':
        include 'order.php';
        break;
    case 'comments':
        include 'comments.php';
        break;
    case 'carts':
        include 'cart.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(array("message" => "Endpoint not found."));
        break;
}
?>
