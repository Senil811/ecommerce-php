<?php
include 'db.php';

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        // Retrieve all orders for a specific user
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];

            $query = "SELECT order_id, order_date FROM orders WHERE user_id = :user_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $orders_arr = array();
                $orders_arr["records"] = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $order_item = array(
                        "order_id" => $order_id,
                        "order_date" => $order_date,
                    );

                    array_push($orders_arr["records"], $order_item);
                }

                http_response_code(200);
                echo json_encode($orders_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "No orders found for the user."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "User ID is missing."));
        }
        break;
    case 'POST':
        // Create a new order for a user
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->user_id) && isset($data->product_id) && isset($data->quantity)) {
            $user_id = $data->user_id;
            $product_id = $data->product_id;
            $quantity = $data->quantity;

            // Check if the product exists and has sufficient quantity in the cart (you can implement this logic based on your requirements)

            $query = "INSERT INTO orders (user_id) VALUES (:user_id)";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':user_id', $user_id);

            if ($stmt->execute()) {
                $order_id = $pdo->lastInsertId();

                // Add the order items
                $query = "INSERT INTO orderitems (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
                $stmt = $pdo->prepare($query);

                $stmt->bindParam(':order_id', $order_id);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':quantity', $quantity);

                if ($stmt->execute()) {
                    http_response_code(201);
                    echo json_encode(array("message" => "Order created."));
                } else {
                    http_response_code(503);
                    echo json_encode(array("message" => "Unable to create order items."));
                }
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create order."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Data is incomplete."));
        }
        break;
    default:
        // Invalid request method
        http_response_code(405);
        echo json_encode(array("message" => "Invalid request method."));
        break;
}
?>
