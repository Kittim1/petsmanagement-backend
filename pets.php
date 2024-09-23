<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php';

class PetManagementAPI
{
    // Users operations
    function addUser($json)
    {
        include 'db.php';
        $json = json_decode($json, true);
        $sql = "INSERT INTO Users(Username, Email, Password, Role) VALUES(:username, :email, :password, :role)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $json["username"]);
        $stmt->bindParam(":email", $json["email"]);
        $stmt->bindParam(":password", password_hash($json["password"], PASSWORD_DEFAULT));
        $stmt->bindParam(":role", $json["role"]);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? 1 : 0;
    }

    function updateUser($json)
    {
        include 'db.php';
        $json = json_decode($json, true);
        $sql = "UPDATE Users SET Username = :username, Email = :email, Role = :role WHERE UserID = :userid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $json["username"]);
        $stmt->bindParam(":email", $json["email"]);
        $stmt->bindParam(":role", $json["role"]);
        $stmt->bindParam(":userid", $json["userid"]);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? 1 : 0;
    }

    function deleteUser($json)
    {
        include 'db.php';
        $json = json_decode($json, true);
        $sql = "DELETE FROM Users WHERE UserID = :userid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":userid", $json["userid"]);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? 1 : 0;
    }

    function getUserDetails()
    {
        include 'db.php';
        $sql = "SELECT UserID, Username, Email, Role FROM Users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    // Pets operations
    function addPet($json)
    {
        include 'db.php';
        $json = json_decode($json, true);
        $sql = "INSERT INTO Pets(Name, Species, Breed, Age, Photo, OwnerID) VALUES(:name, :species, :breed, :age, :photo, :ownerid)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":name", $json["name"]);
        $stmt->bindParam(":species", $json["species"]);
        $stmt->bindParam(":breed", $json["breed"]);
        $stmt->bindParam(":age", $json["age"]);
        $stmt->bindParam(":photo", $json["photo"]);
        $stmt->bindParam(":ownerid", $json["ownerid"]);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? 1 : 0;
    }

    function updatePet($json)
    {
        include 'db.php';
        $json = json_decode($json, true);
        $sql = "UPDATE Pets SET Name = :name, Species = :species, Breed = :breed, Age = :age, Photo = :photo WHERE PetID = :petid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":name", $json["name"]);
        $stmt->bindParam(":species", $json["species"]);
        $stmt->bindParam(":breed", $json["breed"]);
        $stmt->bindParam(":age", $json["age"]);
        $stmt->bindParam(":photo", $json["photo"]);
        $stmt->bindParam(":petid", $json["petid"]);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? 1 : 0;
    }

    function deletePet($json)
    {
        include 'db.php';
        $json = json_decode($json, true);
        $sql = "DELETE FROM Pets WHERE PetID = :petid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":petid", $json["petid"]);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? 1 : 0;
    }

    function getPetDetails()
    {
        include 'db.php';
        $sql = "SELECT p.*, u.Username as OwnerName FROM Pets p JOIN Users u ON p.OwnerID = u.UserID";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    // VeterinaryRecords operations
    function addVeterinaryRecord($json)
    {
        include 'db.php';
        $json = json_decode($json, true);
        $sql = "INSERT INTO VeterinaryRecords(PetID, VetID, Diagnosis, Treatment, Prescription, VisitDate) VALUES(:petid, :vetid, :diagnosis, :treatment, :prescription, :visitdate)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":petid", $json["petid"]);
        $stmt->bindParam(":vetid", $json["vetid"]);
        $stmt->bindParam(":diagnosis", $json["diagnosis"]);
        $stmt->bindParam(":treatment", $json["treatment"]);
        $stmt->bindParam(":prescription", $json["prescription"]);
        $stmt->bindParam(":visitdate", $json["visitdate"]);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? 1 : 0;
    }

    function updateVeterinaryRecord($json)
    {
        include 'db.php';
        $json = json_decode($json, true);
        $sql = "UPDATE VeterinaryRecords SET Diagnosis = :diagnosis, Treatment = :treatment, Prescription = :prescription WHERE RecordID = :recordid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":diagnosis", $json["diagnosis"]);
        $stmt->bindParam(":treatment", $json["treatment"]);
        $stmt->bindParam(":prescription", $json["prescription"]);
        $stmt->bindParam(":recordid", $json["recordid"]);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? 1 : 0;
    }

    function getVeterinaryRecords($json)
    {
        include 'db.php';
        $json = json_decode($json, true);
        $sql = "SELECT vr.*, p.Name as PetName, u.Username as VetName 
                FROM VeterinaryRecords vr 
                JOIN Pets p ON vr.PetID = p.PetID 
                JOIN Users u ON vr.VetID = u.UserID 
                WHERE vr.PetID = :petid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":petid", $json["petid"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }
}

$json = isset($_POST["json"]) ? $_POST["json"] : "0";
$operation = isset($_POST["operation"]) ? $_POST["operation"] : "0";
$api = new PetManagementAPI();

switch ($operation) {
    case "addUser":
        echo $api->addUser($json);
        break;
    case "updateUser":
        echo $api->updateUser($json);
        break;
    case "deleteUser":
        echo $api->deleteUser($json);
        break;
    case "getUserDetails":
        echo $api->getUserDetails();
        break;
    case "addPet":
        echo $api->addPet($json);
        break;
    case "updatePet":
        echo $api->updatePet($json);
        break;
    case "deletePet":
        echo $api->deletePet($json);
        break;
    case "getPetDetails":
        echo $api->getPetDetails();
        break;
    case "addVeterinaryRecord":
        echo $api->addVeterinaryRecord($json);
        break;
    case "updateVeterinaryRecord":
        echo $api->updateVeterinaryRecord($json);
        break;
    case "getVeterinaryRecords":
        echo $api->getVeterinaryRecords($json);
        break;
    default:
        echo json_encode(["error" => "Invalid operation"]);
        break;
}