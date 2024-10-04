<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

class UserOperations
{
    function handleCreateUser($data)
    {
        include 'db.php';
        $query = "INSERT INTO tbl_users (Username, Password, Email, FirstName, LastName, Role) 
                  VALUES (:Username, :Password, :Email, :FirstName, :LastName, :Role)";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':Username' => $data['Username'],
            ':Password' => password_hash($data['Password'], PASSWORD_DEFAULT),
            ':Email' => $data['Email'],
            ':FirstName' => $data['FirstName'],
            ':LastName' => $data['LastName'],
            ':Role' => $data['Role']
        ]);
        
        if ($stmt->rowCount() > 0) {
            return json_encode(['success' => true, 'message' => 'User created successfully', 'id' => $pdo->lastInsertId(), 'operation' => 'createUser']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to create user', 'operation' => 'createUser']);
        }
    }

    function handleGetUser($data)
    {
        include 'db.php';
        $query = "SELECT UserID, Username, Email, FirstName, LastName, Role FROM tbl_users WHERE UserID = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $data['id']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return json_encode(['success' => true, 'data' => $result, 'operation' => 'getUser']);
        } else {
            return json_encode(['success' => false, 'message' => 'User not found', 'operation' => 'getUser']);
        }
    }

    function handleUpdateUser($data)
    {
        include 'db.php';
        $query = "UPDATE tbl_users SET Username = :Username, Email = :Email, FirstName = :FirstName, 
                  LastName = :LastName, Role = :Role WHERE UserID = :UserID";
        
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([
            ':Username' => $data['Username'],
            ':Email' => $data['Email'],
            ':FirstName' => $data['FirstName'],
            ':LastName' => $data['LastName'],
            ':Role' => $data['Role'],
            ':UserID' => $data['UserID']
        ]);
        
        if ($result) {
            return json_encode(['success' => true, 'message' => 'User updated successfully', 'operation' => 'updateUser']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to update user', 'operation' => 'updateUser']);
        }
    }

    function handleDeleteUser($data)
    {
        include 'db.php';
        $query = "DELETE FROM tbl_users WHERE UserID = :id";
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([':id' => $data['id']]);
        
        if ($result) {
            return json_encode(['success' => true, 'message' => 'User deleted successfully', 'operation' => 'deleteUser']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to delete user', 'operation' => 'deleteUser']);
        }
    }

    function handleListUsers()
    {
        include 'db.php';
        $query = "SELECT UserID, Username, Email, FirstName, LastName, Role FROM tbl_users";
        $stmt = $pdo->query($query);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode(['success' => true, 'data' => $users, 'operation' => 'listUsers']);
    }

    function handleLogin($data)
    {
        include 'db.php';
        $query = "SELECT UserID, Username, Password, Role FROM tbl_users WHERE Username = :Username";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':Username' => $data['Username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($data['Password'], $user['Password'])) {
            unset($user['Password']); // Remove password from the response
            return json_encode(['success' => true, 'message' => 'Login successful', 'user' => $user, 'operation' => 'login']);
        } else {
            return json_encode(['success' => false, 'message' => 'Invalid username or password', 'operation' => 'login']);
        }
    }
}

$json = isset($_POST["json"]) ? $_POST["json"] : "0";
$operation = isset($_POST["operation"]) ? $_POST["operation"] : "0";

$userOps = new UserOperations();

switch ($operation) {
    case "login":
        echo $userOps->handleLogin(json_decode($json, true));
        break;
    case "register":
        // Changed from handleRegister to handleCreateUser
        echo $userOps->handleCreateUser(json_decode($json, true));
        break;
    case "createUser":
        echo $userOps->handleCreateUser(json_decode($json, true));
        break;
    case "getUser":
        echo $userOps->handleGetUser(json_decode($json, true));
        break;
    case "updateUser":
        echo $userOps->handleUpdateUser(json_decode($json, true));
        break;
    case "deleteUser":
        echo $userOps->handleDeleteUser(json_decode($json, true));
        break;
    case "listUsers":
        echo $userOps->handleListUsers();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid operation', 'operation' => $operation]);
        break;
}

?>
