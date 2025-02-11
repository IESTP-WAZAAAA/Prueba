<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] === 'invitado') {
    echo json_encode(["status" => "error", "message" => "No tienes permisos para eliminar."]);
    exit;
}

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
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "ID no válido"]);
    exit;
}

// Eliminar consulta
$stmt = $conn->prepare("DELETE FROM consultas WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Consulta eliminada correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo eliminar"]);
}

$stmt->close();
$conn->close();
?>
