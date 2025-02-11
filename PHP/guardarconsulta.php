<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] === 'invitado') {
    echo json_encode(["status" => "error", "message" => "Debes iniciar sesión para enviar una consulta."]);
    exit;
}

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'jovenes';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Error en la conexión a la base de datos."]);
    exit;
}

$documentos = $_POST['documentos'] ?? '';
$nombress = $_POST['nombress'] ?? '';
$apellidoPaternos = $_POST['apellidoPaternos'] ?? '';
$email = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';


$stmt = $conn->prepare("INSERT INTO consultas (documentos, nombress, apellidoPaternos, email, telefono, mensaje) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $documentos, $nombress, $apellidoPaternos, $email, $telefono, $mensaje);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Consulta enviada con éxito."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al guardar la consulta."]);
}

$stmt->close();
$conn->close();
?>
