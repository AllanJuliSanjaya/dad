<?php
    require 'db.php';

    // Set headers agar klien dapat berkomunikasi dengan API
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // Ambil metode HTTP (GET, POST, PUT, DELETE)
    $method = $_SERVER['REQUEST_METHOD'];

    // Ambil data dari body request
    $data = json_decode(file_get_contents("php://input"), true);

    // Ambil ID jika ada
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    switch ($method) {
        case 'GET':
            $sql = "SELECT * FROM users";
            if ($id) {
                $sql .= " WHERE id = '$id'";
            }
            $result = $conn->query($sql);
            $users = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row;
                }
            }
            echo json_encode($users);
            break;
        case 'POST':
            $name = $data['name'];
            $email = $data['email'];
            $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['message' => 'User created successfully']);
            } else {
                echo json_encode(['error' => 'Error creating user: ' . $conn->error]);
            }
            break;
        case 'PUT':
            $name = $data['name'];
            $email = $data['email'];
            $sql = "UPDATE users SET name='$name', email='$email' WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['message' => 'User updated successfully']);
            } else {
                echo json_encode(['error' => 'Error updating user: ' . $conn->error]);
            }
            break;
        case 'DELETE':
            $sql = "DELETE FROM users WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['message' => 'User deleted successfully']);
            } else {
                echo json_encode(['error' => 'Error deleting user: ' . $conn->error]);
            }
            break;
        default:
            echo json_encode(['error' => 'Invalid Request']);
            break;
    }

    $conn->close();
