<?php
require 'db.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'login':
                handleLogin($conn, $data);
                break;
            case 'register':
                handleRegister($conn, $data);
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No action specified']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

function handleLogin($conn, $data) {
    $email = $data['email'];
    $password = $data['password'];

    $stmt = $conn->prepare("SELECT UserID, Username, Email, Password, Role FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            unset($user['Password']); // Remove password from the response
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }

    $stmt->close();
}

function handleRegister($conn, $data) {
    $username = $data['username'];
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $role = $data['role'];

    $stmt = $conn->prepare("INSERT INTO Users (Username, Email, Password, Role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User registered successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed']);
    }

    $stmt->close();
}

?>
