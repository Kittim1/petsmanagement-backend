<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

class UserOperations
{
    function handleLogin($data)
    {
        include 'db.php';
        $username = $data['username'];
        $password = $data['password'];

        $stmt = $conn->prepare("SELECT UserID, Username, Email, Password, user_level FROM Users WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['Password'])) {
                unset($user['Password']);
                return json_encode(['success' => true, 'user' => $user, 'operation' => 'login']);
            } else {
                return json_encode(['success' => false, 'message' => 'Invalid credentials', 'operation' => 'login']);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'User not found', 'operation' => 'login']);
        }
    }

    function handleRegister($data)
    {
        include 'db.php';
        $username = $data['username'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $firstName = $data['firstName'] ?? null;
        $lastName = $data['lastName'] ?? null;
        $userLevel = 'owner'; // Set default user level to 'owner'

        // Check if email already exists
        $stmt = $conn->prepare("SELECT UserID FROM Users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return json_encode(['success' => false, 'message' => 'Email already exists', 'operation' => 'register']);
        }
        
        $stmt->close();

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO Users (Username, Email, Password, user_firstname, user_lastname, user_level) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $email, $password, $firstName, $lastName, $userLevel);

        if ($stmt->execute()) {
            return json_encode(['success' => true, 'message' => 'User registered successfully', 'operation' => 'register']);
        } else {
            return json_encode(['success' => false, 'message' => 'Registration failed', 'operation' => 'register']);
        }
    }

    // Add more functions for other operations as needed
}

$json = isset($_POST["json"]) ? $_POST["json"] : "0";
$operation = isset($_POST["operation"]) ? $_POST["operation"] : "0";

$userOps = new UserOperations();

switch ($operation) {
    case "login":
        echo $userOps->handleLogin(json_decode($json, true));
        break;
    case "register":
        echo $userOps->handleRegister(json_decode($json, true));
        break;
    default:
        break;
}

?>
