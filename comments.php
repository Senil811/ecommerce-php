<?php
include 'db.php';

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        // Retrieve all comments for a specific product
        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];

            $query = "SELECT comment_id, user_id, rating, image_url, comment_text FROM comments WHERE product_id = :product_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $comments_arr = array();
                $comments_arr["records"] = array();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $comment_item = array(
                        "comment_id" => $comment_id,
                        "user_id" => $user_id,
                        "rating" => $rating,
                        "image_url" => $image_url,
                        "comment_text" => html_entity_decode($comment_text),
                    );

                    array_push($comments_arr["records"], $comment_item);
                }

                http_response_code(200);
                echo json_encode($comments_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "No comments found for the product."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Product ID is missing."));
        }
        break;
    case 'POST':
        // Add a new comment to a product
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->product_id) && isset($data->user_id) && isset($data->rating) && isset($data->comment_text)) {
            $product_id = $data->product_id;
            $user_id = $data->user_id;
            $rating = $data->rating;
            $image_url = isset($data->image_url) ? $data->image_url : '';
            $comment_text = $data->comment_text;

            $query = "INSERT INTO comments (product_id, user_id, rating, image_url, comment_text) 
                      VALUES (:product_id, :user_id, :rating, :image_url, :comment_text)";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':comment_text', $comment_text);

            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(array("message" => "Comment added."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to add comment."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Data is incomplete."));
        }
        break;
    case 'PUT':
        // Update an existing comment
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->comment_id) && isset($data->rating) && isset($data->comment_text)) {
            $comment_id = $data->comment_id;
            $rating = $data->rating;
            $image_url = isset($data->image_url) ? $data->image_url : '';
            $comment_text = $data->comment_text;

            $query = "UPDATE comments SET rating = :rating, image_url = :image_url, comment_text = :comment_text WHERE comment_id = :comment_id";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':comment_id', $comment_id);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':comment_text', $comment_text);

            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(array("message" => "Comment updated."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to update comment."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Data is incomplete."));
        }
        break;
    case 'DELETE':
        // Delete a comment
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->comment_id)) {
            $comment_id = $data->comment_id;

            $query = "DELETE FROM comments WHERE comment_id = :comment_id";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':comment_id', $comment_id);

            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(array("message" => "Comment deleted."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to delete comment."));
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
