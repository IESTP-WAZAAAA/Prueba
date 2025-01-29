<?php
header('Content-Type: application/json; charset=utf-8');
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'jovenes';

// Conexión a la base de datos
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$usuario = $_POST['usuario'] ?? '';
$contraseña = $_POST['contraseña'] ?? '';

// Validar que los campos no estén vacíos
if (empty($usuario) || empty($contraseña)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos.']);
    exit;
}

// Consultar usuario en la base de datos
$sql = "SELECT * FROM personas WHERE usuario = ? AND contraseña = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $usuario, $contraseña);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos.']);
}

$stmt->close();
$conn->close();
?>
