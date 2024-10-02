<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

class AppointmentOperations
{
    function handleCreateAppointment($data)
    {
        include 'db.php';
        $query = "INSERT INTO tbl_appointment (PetID, OwnerID, VetID, AppointmentDate, AppointmentTime, ReasonForVisit, Status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiissss", $data['PetID'], $data['OwnerID'], $data['VetID'], $data['AppointmentDate'], 
                          $data['AppointmentTime'], $data['ReasonForVisit'], $data['Status']);
        
        if ($stmt->execute()) {
            return json_encode(['success' => true, 'message' => 'Appointment created successfully', 'id' => $stmt->insert_id, 'operation' => 'createAppointment']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to create appointment', 'operation' => 'createAppointment']);
        }
    }

    function handleGetAppointment($data)
    {
        include 'db.php';
        $query = "SELECT * FROM tbl_appointment WHERE AppointmentID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $data['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return json_encode(['success' => true, 'data' => $result->fetch_assoc(), 'operation' => 'getAppointment']);
        } else {
            return json_encode(['success' => false, 'message' => 'Appointment not found', 'operation' => 'getAppointment']);
        }
    }

    function handleUpdateAppointment($data)
    {
        include 'db.php';
        $query = "UPDATE tbl_appointment SET PetID = ?, OwnerID = ?, VetID = ?, AppointmentDate = ?, 
                  AppointmentTime = ?, ReasonForVisit = ?, Status = ? WHERE AppointmentID = ?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiissssi", $data['PetID'], $data['OwnerID'], $data['VetID'], $data['AppointmentDate'], 
                          $data['AppointmentTime'], $data['ReasonForVisit'], $data['Status'], $data['AppointmentID']);
        
        if ($stmt->execute()) {
            return json_encode(['success' => true, 'message' => 'Appointment updated successfully', 'operation' => 'updateAppointment']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to update appointment', 'operation' => 'updateAppointment']);
        }
    }

    function handleDeleteAppointment($data)
    {
        include 'db.php';
        $query = "DELETE FROM tbl_appointment WHERE AppointmentID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $data['id']);
        
        if ($stmt->execute()) {
            return json_encode(['success' => true, 'message' => 'Appointment deleted successfully', 'operation' => 'deleteAppointment']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to delete appointment', 'operation' => 'deleteAppointment']);
        }
    }

    function handleListAppointments($data)
    {
        include 'db.php';
        $query = "SELECT * FROM tbl_appointment WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($data['PetID'])) {
            $query .= " AND PetID = ?";
            $params[] = $data['PetID'];
            $types .= "i";
        }

        if (!empty($data['OwnerID'])) {
            $query .= " AND OwnerID = ?";
            $params[] = $data['OwnerID'];
            $types .= "i";
        }

        if (!empty($data['VetID'])) {
            $query .= " AND VetID = ?";
            $params[] = $data['VetID'];
            $types .= "i";
        }

        if (!empty($data['Status'])) {
            $query .= " AND Status = ?";
            $params[] = $data['Status'];
            $types .= "s";
        }

        $stmt = $conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        
        return json_encode(['success' => true, 'data' => $appointments, 'operation' => 'listAppointments']);
    }
}

$json = isset($_POST["json"]) ? $_POST["json"] : "0";
$operation = isset($_POST["operation"]) ? $_POST["operation"] : "0";

$appointmentOps = new AppointmentOperations();
switch ($operation) {
    case "createAppointment":
        echo $appointmentOps->handleCreateAppointment(json_decode($json, true));
        break;
    case "getAppointment":
        echo $appointmentOps->handleGetAppointment(json_decode($json, true));
        break;
    case "updateAppointment":
        echo $appointmentOps->handleUpdateAppointment(json_decode($json, true));
        break;
    case "deleteAppointment":
        echo $appointmentOps->handleDeleteAppointment(json_decode($json, true));
        break;
    case "listAppointments":
        echo $appointmentOps->handleListAppointments(json_decode($json, true));
        break;
    default:
        break;
}

?>
