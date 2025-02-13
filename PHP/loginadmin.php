<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "jovenes";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuarioadmin = htmlspecialchars(trim($_POST['usuarioadmin']));
    $password = htmlspecialchars(trim($_POST['password']));

    $stmt = $conn->prepare("SELECT password FROM administracion WHERE usuarioadmin = ?");
    $stmt->bind_param("s", $usuarioadmin);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            $_SESSION['usuarioadmin'] = $usuarioadmin;
            header("Location: ../administración.php");
            exit();
        } else {
            echo "<script>alert('Usuario o contraseña incorrectos'); history.back();</script>";
        }
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); history.back();</script>";
    }
    
    $stmt->close();
}

$conn->close();
?>
