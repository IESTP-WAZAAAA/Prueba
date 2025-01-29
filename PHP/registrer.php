<?php
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'jovenes';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexión fallida: " . $conn->connect_error]);
    exit;
}

$documento = $_POST['documento'] ?? '';
$nombres = $_POST['nombres'] ?? '';
$apellidoPaterno = $_POST['apellidoPaterno'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$contraseña = $_POST['contraseña'] ?? '';

// Validar campos vacíos
if (empty($documento) || empty($nombres) || empty($apellidoPaterno) || empty($usuario) || empty($contraseña)) {
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
    exit;
}

// Validar el formato del DNI
if (!preg_match('/^\d{8}$/', $documento)) {
    echo json_encode(["status" => "error", "message" => "El DNI debe tener 8 dígitos."]);
    exit;
}

// Verificar duplicados
$sql_check = "SELECT * FROM personas WHERE usuario = ? OR documento = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param('ss', $usuario, $documento);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "El usuario o DNI ya están registrados."]);
    $stmt_check->close();
    exit;
}
$stmt_check->close();

// Encriptar la contraseña
$hashed_password = password_hash($contraseña, PASSWORD_BCRYPT);

// Insertar en la base de datos
$sql_insert = "INSERT INTO personas (documento, nombres, apellidoPaterno, usuario, contraseña) VALUES (?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param('sssss', $documento, $nombres, $apellidoPaterno, $usuario, $hashed_password);

if ($stmt_insert->execute()) {
    echo json_encode(["status" => "success", "message" => "Registro exitoso."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al guardar los datos: " . $stmt_insert->error]);
}

$stmt_insert->close();
$conn->close();
?>
