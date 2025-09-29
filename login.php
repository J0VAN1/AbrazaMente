<?php
// LOGIN.PHP CAMBIOS ECHOS EN EQUIPO:
// -------------------------------
// Correcciones min. funcionales aplicadas:
// 1) Mover logica PHP session_start(), redirecciones y consultas
//    AL INICIO del archivo antes de cualquier salida HTML para evitar
//    headers already sent [listo]
// 2) prepared statements (mysqli) [listo]
// 3) contraseñas hashed (password_verify)migrar a password_hash [x]
// 4) Salir (exit) tras header('Location: ...') [x]
// 5) Val. min. del email y saneamiento de la salida [x]
// 6) Logica | presentación y HTML separados [x]
// -------------------------------
session_start();
date_default_timezone_set('Asia/Kolkata');

// asume que connection.php define $database (mysqli)
include 'connection.php';

// Inicializo variables -> presentar errores en el HTML
$error_html = '<label for="promter" class="form-label">&nbsp;</label>';
$user_email = '';

// Utilizar REQUEST_METHOD para detectar POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanear entradas básicas
    $user_email = trim($_POST['useremail'] ?? '');
    $user_password = $_POST['userpassword'] ?? '';

    // Validacion
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $error_html = '<label class="form-label" style="color:rgb(255,62,62);text-align:center;">Email inválido.</label>';
    } elseif ($user_password === '') {
        $error_html = '<label class="form-label" style="color:rgb(255,62,62);text-align:center;">Contraseña requerida.</label>';
    } else {
        // 1) Obtener el tipo de usuario desde webuser (prepared statement)
        $stmt = $database->prepare("SELECT usertype FROM webuser WHERE email = ?");
        if ($stmt === false) {
            // Falla extrema: preparar statement
            $error_html = '<label class="form-label" style="color:rgb(255,62,62);text-align:center;">Error interno (prepare failed).</label>';
        } else {
            $stmt->bind_param('s', $user_email);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res && $res->num_rows === 1) {
                $row = $res->fetch_assoc();
                $utype = $row['usertype'];
                $stmt->close();

                // Mapear tabla, columna de email y contraseña, y destino
                $map = [
                    'p' => ['table' => 'patient', 'email_col' => 'pemail', 'pass_col' => 'ppassword', 'redirect' => 'patient/index.php'],
                    'a' => ['table' => 'admin',   'email_col' => 'aemail', 'pass_col' => 'apassword', 'redirect' => 'admin/index.php'],
                    'd' => ['table' => 'doctor',  'email_col' => 'docemail','pass_col' => 'docpassword','redirect' => 'doctor/index.php'],
                ];

                if (!isset($map[$utype])) {
                    $error_html = '<label class="form-label" style="color:rgb(255,62,62);text-align:center;">Tipo de usuario desconocido.</label>';
                } else {
                    $info = $map[$utype];
                    // 2) Obtener hash/valor de contraseña desde la tabla correspondiente
                    // Usamos nombres de columna y tabla controlados por el map, no por input.
                    $sql = "SELECT `{$info['pass_col']}` AS passwd FROM `{$info['table']}` WHERE `{$info['email_col']}` = ? LIMIT 1";
                    $stmt2 = $database->prepare($sql);
                    if ($stmt2 === false) {
                        $error_html = '<label class="form-label" style="color:rgb(255,62,62);text-align:center;">Error interno (prepare2 failed).</label>';
                    } else {
                        $stmt2->bind_param('s', $user_email);
                        $stmt2->execute();
                        $res2 = $stmt2->get_result();

                        if ($res2 && $res2->num_rows === 1) {
                            $r = $res2->fetch_assoc();
                            $stored = $r['passwd'];
                            $stmt2->close();

                            $login_ok = false;

                            // Si el valor almacenado parece ser un hash de password_hash()
                            // los hashes bcrypt empiezan por $2y$ o $2a$, argon2 por '$argon', etc.
                            if (is_string($stored) && (strpos($stored, '$2y$') === 0 || strpos($stored, '$2a$') === 0 || strpos($stored, '$argon') === 0)) {
                                // DB ya tiene hashes: comprobar con password_verify
                                if (password_verify($user_password, $stored)) {
                                    $login_ok = true;
                                }
                            } else {
                                // Caso: contraseña en texto plano en BD (temporal) -> comparar directamente.
                                // ADVERTENCIA: INSEGURO. no poderemos migrarlo a tiempo.  
                                if ($user_password === $stored) {
                                    $login_ok = true;
                                }
                            }

                            if ($login_ok) {
                                // SESION y redireccion
                                $_SESSION['user'] = $user_email;
                                $_SESSION['usertype'] = $utype;
                                $_SESSION['date'] = date('Y-m-d');
                                header('Location: ' . $info['redirect']);
                                exit; // IMPORTANTE: parar ejecución tras redireccion
                            } else {
                                $error_html = '<label class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                            }

                        } else {
                            // No existe fila en tabla especfica
                            $error_html = '<label class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                            $stmt2->close();
                        }
                    }
                }

            } else {
                // No existe el email en webuser
                $error_html = '<label class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We can\'t find any account for this email.</label>';
                $stmt->close();
            }
        }
    }
}
// Fin pros. POST
// -------------------------------
// Imprimir html
// -------------------------------
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Mantén tus CSS -->
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <center>
        <div class="container" style="width:60%; max-width: 700px;">
            <p class="header-text">TU CONFIANZA NOS IMPORTA!</p>
            <p class="sub-text">Inicia seción para agendar, consultar y acompañar</p>

            <!-- Form: fuera de la tabla para evitar anidamiento invalido -->
            <form action="" method="POST" style="display:inline-block; width:100%; max-width:500px;">
                <div class="label-td">
                    <label for="useremail" class="form-label">Correo(gmail):</label><br>
                    <input id="useremail" type="email" name="useremail" class="input-text" placeholder="Email Address" required
                        value="<?php echo htmlspecialchars($user_email, ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="label-td" style="margin-top:10px;">
                    <label for="userpassword" class="form-label">Contraseña:</label><br>
                    <input id="userpassword" type="password" name="userpassword" class="input-text" placeholder="Password" required>
                </div>

                <div style="margin-top:10px;">
                    <?php
                        // Imprimimos el HTML del error (lo generamos nosotros, no contenido libre del usuario)
                        echo $error_html;
                    ?>
                </div>

                <div style="margin-top:12px;">
                    <input type="submit" value="Login" class="login-btn btn-primary btn">
                </div>
            </form>

            <div style="margin-top:18px;">
                <label class="sub-text" style="font-weight: 280;">Si aun no tienes cuenta: </label>
                <a href="signup.php" class="hover-link1 non-style-link">REGISTRARME</a>
            </div>
        </div>
    </center>
</body>
</html>
