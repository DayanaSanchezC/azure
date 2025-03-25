<?php
session_start();

// Definir usuarios y contraseñas de manera estática (solo para demostración)
$usuarios = [
    'usuario1' => 'password1',
    'usuario2' => 'password2',
];

// Variable para mensajes
$mensaje = "";
$clase_mensaje = "";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el usuario existe y la contraseña es correcta
    if (isset($usuarios[$username]) && $usuarios[$username] == $password) {
        $_SESSION['username'] = $username;
        $mensaje = "¡Login exitoso!";
        $clase_mensaje = "success";
    } else {
        $mensaje = "Usuario o contraseña incorrectos";
        $clase_mensaje = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .login-btn {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-btn:hover {
            background-color: #218838;
        }
        .mensaje {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            width: 300px;
            text-align: center;
            font-weight: bold;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <?php if (!empty($mensaje)) { ?>
        <div class="mensaje <?php echo $clase_mensaje; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php } ?>

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" class="input-field" placeholder="Usuario" required>
            <input type="password" name="password" class="input-field" placeholder="Contraseña" required>
            <button type="submit" class="login-btn">Iniciar sesión</button>
        </form>
    </div>

</body>
</html>
