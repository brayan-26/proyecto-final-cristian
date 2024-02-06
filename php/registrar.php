<?php
$conexion = new mysqli("localhost", "root", "", "tienda");

if ($conexion->connect_error) {
    die("La conexión a la base de datos ha fallado: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST["nombreUsuario"];
    $telefono = $_POST["telefono"];
    $cedula = $_POST["cedula"];
    $correo = $_POST["correo"];
    $contraseña = $_POST["contraseña"];
    $confirmarContraseña = $_POST["confirmarContraseña"];

    // Verificar la conexión
    $correoExistenteQuery = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $correoExistenteResult = $conexion->query($correoExistenteQuery);

    if ($correoExistenteResult->num_rows > 0) {
        // El correo ya está registrado
        echo "<div style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; border: 1px solid #808080; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; font-family: \"Times New Roman\", Times, serif; font-size: 20px !important;'>";
        echo "<p style='margin-bottom: 20px;'>El correo electrónico $correo ya está registrado. Por favor, elija otro correo.</p>";
        echo "<a href='registrar.html' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;'>Volver</a>";
        echo "</div>";
    } else if (empty($nombreUsuario) || empty($correo) || empty($telefono) || empty($cedula) || empty($contraseña) || empty($confirmarContraseña)) {
        // Campos vacíos
        echo "<div style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; border: 1px solid #808080; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; font-family: \"Times New Roman\", Times, serif; font-size: 20px !important;'>";
        echo "<p style='margin-bottom: 20px;'>Ingrese todos los datos</p>";
        echo "<a href='registrar.html' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;'>Volver</a>";
        echo "</div>";
    } else {
        $uppercase = preg_match('@[A-Z]@', $contraseña);
        $numbers = preg_match('@[0-9]@', $contraseña);
        $specialChars = preg_match('/[^A-Za-z0-9]/', $contraseña);

        if (strlen($contraseña) < 8 || !$uppercase || !$numbers || !$specialChars) {
            // Contraseña no cumple con los requisitos
            echo "<div style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; border: 1px solid #808080; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; font-family: \"Times New Roman\", Times, serif; font-size: 20px !important;'>";
            echo "<p style='margin-bottom: 20px;'>La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial. Asegúrese de que las contraseñas coincidan.</p>";
            echo "<a href='registrar.html' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;'>Volver</a>";
            echo "</div>";
        } else if ($contraseña !== $confirmarContraseña) {
            // Las contraseñas no coinciden
            echo "<div style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; border: 1px solid #808080; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; font-family: \"Times New Roman\", Times, serif; font-size: 20px !important;'>";
            echo "<p style='margin-bottom: 20px;'>Las contraseñas no coinciden. Por favor, inténtelo de nuevo.</p>";
            echo "<a href='registrar.html' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;'>Volver</a>";
            echo "</div>";
        } else {
            // Contraseña cumple con los requisitos y coincide con la confirmación
            $sql = "INSERT INTO usuarios (nombreUsuario, telefono, cedula, correo, contraseña) VALUES ('$nombreUsuario', '$telefono', '$cedula', '$correo', '$contraseña')";

            if ($conexion->query($sql) === TRUE) {
                echo "Registro exitoso";
                header("Location: ../html/index.html");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
        }
    }
}

$conexion->close();
?>
