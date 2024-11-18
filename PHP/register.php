<?php
// Incluir el archivo de conexión
include '../conexion.php';

// Obtener los datos del POST
$username = $_POST['username'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$password = $_POST['password']; // Esta es la contraseña en texto claro
$dni = $_POST['dni']; // Obtener el DNI
$status = 'loggedOff'; // Valor por defecto
$role = 'Usuario'; // Valor por defecto

// Verificar si el nombre de usuario, correo o DNI ya existen
$sql_check = "SELECT * FROM usuarios WHERE username = ? OR correo = ? OR dni = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("sss", $username, $email, $dni);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    // Si existe, devolver un error
    echo json_encode(['status' => 'error', 'message' => 'Username, correo o DNI ya existe']);
} else {
    // Hashear la contraseña
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Preparar y ejecutar la consulta
    $sql = "INSERT INTO usuarios (username, rol, nombres, apellidos, dni, correo, password, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $username, $role, $nombres, $apellidos, $dni, $email, $hashed_password, $status);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Registro exitoso']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error en el registro']);
    }

    // Cerrar la conexión
    $stmt->close();
}

$stmt_check->close();
$conn->close();
?>
