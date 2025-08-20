<?php
session_start();
require 'config/conexion.php';

$usuario = mysqli_real_escape_string($conn, $_POST['user']);
$password = $_POST['pass'];
$password_encriptada = md5($password); // si usas MD5 en tu BD

$query = "SELECT * FROM usuario WHERE nombre_usuario = ? AND clave = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $usuario, $password_encriptada);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    // Guardar datos en sesión
    $_SESSION['id_usuario'] = $row['id_usuario'];
    $_SESSION['nombre'] = $row['nombre'];
    $_SESSION['rol'] = $row['rol']; // 👈 Guardamos el rol
    echo 'success';
} else {
    echo 'error';
}

$stmt->close();
$conn->close();
?>
