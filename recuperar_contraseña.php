<?php
// Establecer conexión a la base de datos (reemplaza estos valores con los tuyos)
$servername = "ghanjadrops.mysql.database.azure.com";
$username = "johan";
$password = "MONSALVE#2006";
$dbname = "ghanjadrops";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email']; // Obtener el correo electrónico proporcionado por el usuario

    // Consulta SQL para verificar si el correo existe en la tabla de usuarios
    $sql = "SELECT correo FROM usuarios WHERE correo = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // El correo existe en la base de datos, proceder con el envío del correo de recuperación
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $subject = "Recuperación de contraseña";
        $message = "Su código de verificación o token es: $token. Para restablecer tu contraseña, haz clic en este enlace: https://127.0.0.1/GHANJADROPS/nueva_contraseña.html?token=$token";
        $headers = "From: ghanjadropselmejorproyecto2023@gmail.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "<script>alert('Correo enviado con éxito');</script>";
        } else {
            echo "<script>alert('Error al enviar el correo');</script>";
        }

        // Mostrar alerta de éxito
        include("./contraseña.html");
    } else {
        // Mostrar alerta si el correo no está registrado
        include("./contraseña.html");
        echo "<script>alert('El correo no está registrado');</script>";
    }
} else {
    // Mostrar alerta si el método no es permitido
    include("./contraseña.html");
    echo "<script>alert('Método no permitido');</script>";
}

// Cerrar conexión
$conn->close();
?>
