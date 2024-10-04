<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

class AdoptionOperations
{
    function handleCreateAdoption($data)
    {
        include 'db.php';
        $query = "INSERT INTO tbl_adoptions (PetID, AdopterID, AdoptionDate, Status) 
                  VALUES (:PetID, :AdopterID, :AdoptionDate, :Status)";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':PetID' => $data['PetID'],
            ':AdopterID' => $data['AdopterID'],
            ':AdoptionDate' => $data['AdoptionDate'],
            ':Status' => $data['Status']
        ]);
        
        if ($stmt->rowCount() > 0) {
            return json_encode(['success' => true, 'message' => 'Adoption created successfully', 'id' => $pdo->lastInsertId(), 'operation' => 'createAdoption']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to create adoption', 'operation' => 'createAdoption']);
        }
    }

    function handleGetAdoption($data)
    {
        include 'db.php';
        $query = "SELECT * FROM tbl_adoptions WHERE AdoptionID = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $data['id']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return json_encode(['success' => true, 'data' => $result, 'operation' => 'getAdoption']);
        } else {
            return json_encode(['success' => false, 'message' => 'Adoption not found', 'operation' => 'getAdoption']);
        }
    }

    function handleUpdateAdoption($data)
    {
        include 'db.php';
        $query = "UPDATE tbl_adoptions SET PetID = :PetID, AdopterID = :AdopterID, AdoptionDate = :AdoptionDate, 
                  Status = :Status WHERE AdoptionID = :AdoptionID";
        
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([
            ':PetID' => $data['PetID'],
            ':AdopterID' => $data['AdopterID'],
            ':AdoptionDate' => $data['AdoptionDate'],
            ':Status' => $data['Status'],
            ':AdoptionID' => $data['AdoptionID']
        ]);
        
        if ($result) {
            return json_encode(['success' => true, 'message' => 'Adoption updated successfully', 'operation' => 'updateAdoption']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to update adoption', 'operation' => 'updateAdoption']);
        }
    }

    function handleDeleteAdoption($data)
    {
        include 'db.php';
        $query = "DELETE FROM tbl_adoptions WHERE AdoptionID = :id";
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([':id' => $data['id']]);
        
        if ($result) {
            return json_encode(['success' => true, 'message' => 'Adoption deleted successfully', 'operation' => 'deleteAdoption']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to delete adoption', 'operation' => 'deleteAdoption']);
        }
    }

    function handleListAdoptions()
    {
        include 'db.php';
        $query = "SELECT * FROM tbl_adoptions";
        $stmt = $pdo->query($query);
        $adoptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode(['success' => true, 'data' => $adoptions, 'operation' => 'listAdoptions']);
    }
}

$json = isset($_POST["json"]) ? $_POST["json"] : "0";
$operation = isset($_POST["operation"]) ? $_POST["operation"] : "0";

$adoptionOps = new AdoptionOperations();

switch ($operation) {
    case "createAdoption":
        echo $adoptionOps->handleCreateAdoption(json_decode($json, true));
        break;
    case "getAdoption":
        echo $adoptionOps->handleGetAdoption(json_decode($json, true));
        break;
    case "updateAdoption":
        echo $adoptionOps->handleUpdateAdoption(json_decode($json, true));
        break;
    case "deleteAdoption":
        echo $adoptionOps->handleDeleteAdoption(json_decode($json, true));
        break;
    case "listAdoptions":
        echo $adoptionOps->handleListAdoptions();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid operation', 'operation' => $operation]);
        break;
}

?>