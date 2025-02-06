<?php
session_start();
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'jovenes';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexión fallida: " . $conn->connect_error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $stmt = $conn->prepare("SELECT id, usuario, nombres, contraseña FROM personas WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        if (password_verify($contraseña, $fila['contraseña'])) {
            $_SESSION['usuario'] = $fila['usuario'];
            $_SESSION['nombres'] = $fila['nombres']; 
            header("Location: ../index.php?bienvenido=1");
            exit();
        } else {
            echo "<script>alert('Usuario o contraseña incorrectos'); history.back();</script>";
        }
    } else {
        echo "<script>alert('Usuario o Contraseña incorrectos'); history.back();</script>";
    }
    $stmt->close();
    $conn->close();
}

?>