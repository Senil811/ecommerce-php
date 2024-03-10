<?php
include 'db.php';

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        // Retrieve all products
        $query = "SELECT product_id, name, description, pricing FROM product";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $products_arr = array();
            $products_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $product_item = array(
                    "id" => $product_id,
                    "name" => $name,
                    "description" => html_entity_decode($description),
                    "price" => $pricing,
                    
                );

                array_push($products_arr["records"], $product_item);
            }

            http_response_code(200);
            echo json_encode($products_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No products found."));
        }
        break;
    case 'POST':
        // Create a new product
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->name) && isset($data->price)) {
            $name = $data->name;
            $description = isset($data->description) ? $data->description : '';
            $price = $data->price;

            $query = "INSERT INTO product (name, description, pricing) VALUES (:name, :description, :price)";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);

            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(array("message" => "Product created."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create product."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Data is incomplete."));
        }
        break;
    case 'PUT':
        // Update an existing product
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id) && isset($data->name) && isset($data->price)) {
            $id = $data->id;
            $name = $data->name;
            $description = isset($data->description) ? $data->description : '';
            $price = $data->price;

            $query = "UPDATE product SET name = :name, description = :description, pricing = :price WHERE product_id = :id";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);

            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(array("message" => "Product updated."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to update product."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Data is incomplete."));
        }
        break;
    case 'DELETE':
        // Delete a product
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id)) {
            $id = $data->id;

            $query = "DELETE FROM product WHERE product_id = :id";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(array("message" => "Product deleted."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to delete product."));
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
