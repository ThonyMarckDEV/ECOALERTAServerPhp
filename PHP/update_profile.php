<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos POST
    $username = $_POST['username'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];

    // Incluir el archivo de conexión
    include '../conexion.php';

    // Actualizar la información del perfil
    $sql = "UPDATE usuarios SET nombres=?, apellidos=?, correo=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombres, $apellidos, $correo, $username);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Error al actualizar el perfil"]);
    }

    $stmt->close();
    $conn->close();
}
?>
