<?php
header("Content-Type: application/json");

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'jovenes';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexión fallida: " . $conn->connect_error]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $id = $data['id'];
    $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Usuario eliminado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al eliminar el usuario."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "ID de usuario no proporcionado."]);
}

$conn->close();
