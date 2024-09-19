<?php
// Incluir el archivo de conexión
include '../conexion.php';

// Obtener los datos del POST
$username = $_POST['username'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$password = $_POST['password']; // Esta es la contraseña en texto claro
$status = 'loggedOff'; // Valor por defecto
$role = 'Usuario'; // Valor por defecto

// Hashear la contraseña
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Preparar y ejecutar la consulta
$sql = "INSERT INTO usuarios (username, rol, nombres, apellidos, correo, password, status)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $username, $role, $nombres, $apellidos, $email, $hashed_password, $status);

if ($stmt->execute()) {
    echo "Registro exitoso";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>