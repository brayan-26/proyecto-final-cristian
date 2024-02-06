<?php
// Conexión a la base de datos (debes tener tus propias credenciales)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda";


if ($_SERVER["REQUEST_METHOD"] == "POST") 
    if (isset($_POST["correo"]) && isset($_POST["contraseña"])) {
        $correo = $_POST["correo"];
        $contraseña = $_POST["contraseña"];

    // Validación de contraseña
    if (strlen($contraseña) < 8 || !preg_match("/^[A-Z]/", $contraseña) || !preg_match("/[0-9]/", $contraseña)) {
        echo "El usuario no esta registrado, intentelo de nuevo.";
    } else {
        echo "Los datos del formulario son incorrectos.";

        // Crear la conexión
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Verificar la conexión
        if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

        // Consulta para verificar la existencia del usuario
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND contraseña = '$contraseña'";
        $result = $conn->query($sql);

        // Verificar si se encontró un usuario con las credenciales proporcionadas
        if ($result->num_rows > 0) {
            // Inicio de sesión exitoso
            // Redirigir a la página principal
            header("Location:../html/pagina.html");
        } else {
            // Inicio de sesión fallido
            // Puedes redirigir a una página de error o mostrar un mensaje
            echo "Inicio de sesión fallido. Verifica tus credenciales.";
        }

        // Cerrar la conexión
        $conn->close();
    }
}