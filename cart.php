<?php
include 'db.php';

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        // Retrieve all carts for a specific user
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];

            $query = "SELECT cart_id FROM cart WHERE user_id = :user_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $carts_arr = array();
                $carts_arr["records"] = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $cart_item = array(
                        "cart_id" => $cart_id,
                    );

                    array_push($carts_arr["records"], $cart_item);
                }

                http_response_code(200);
                echo json_encode($carts_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "No carts found for the user."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "User ID is missing."));
        }
        break;
    case 'POST':
        // Create a new cart for a user
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->user_id)) {
            $user_id = $data->user_id;

            $query = "INSERT INTO cart (user_id) VALUES (:user_id)";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':user_id', $user_id);

            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(array("message" => "Cart created."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create cart."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "User ID is missing."));
        }
        break;
    case 'DELETE':
        // Delete a cart for a user
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->cart_id)) {
            $cart_id = $data->cart_id;

            $query = "DELETE FROM cart WHERE cart_id = :cart_id";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':cart_id', $cart_id);

            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(array("message" => "Cart deleted."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to delete cart."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Cart ID is missing."));
        }
        break;
    default:
        // Invalid request method
        http_response_code(405);
        echo json_encode(array("message" => "Invalid request method."));
        break;
}
?>
