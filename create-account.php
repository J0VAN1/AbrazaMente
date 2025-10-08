<?php
session_start();

// Set the new timezone
date_default_timezone_set('America/Mexico_City');
$date = date('Y-m-d');

if(!isset($_SESSION["date"])){
    $_SESSION["date"]=$date;
}

//import database
include("connection.php");

// Verificar conexión
if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

if($_POST){
    // Verificar que los datos de sesión existan
    if(!isset($_SESSION['personal'])) {
        header("location: signup.php");
        exit;
    }

    $fname = $_SESSION['personal']['fname'];
    $lname = $_SESSION['personal']['lname'];
    $name = $fname . " " . $lname;
    $address = $_SESSION['personal']['address'];
    $nic = $_SESSION['personal']['nic'];
    $dob = $_SESSION['personal']['dob'];
    $email = $_POST['newemail'];
    $tele = $_POST['tele'];
    $newpassword = $_POST['newpassword'];
    $cpassword = $_POST['cpassword'];
    
    if ($newpassword == $cpassword){
        // Verificar si el email ya existe
        $sqlmain = "SELECT * FROM webuser WHERE email=?";
        $stmt = $database->prepare($sqlmain);
        if($stmt === false) {
            $error = '<label style="color:red;">Error en la consulta</label>';
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                $error = '<label style="color:red;">Ya existe una cuenta con este email</label>';
            } else {
                // INSERTAR en paciente
                $stmt1 = $database->prepare("INSERT INTO patient (pemail, pname, ppassword, paddress, pnic, pdob, ptel) VALUES (?, ?, ?, ?, ?, ?, ?)");
                if($stmt1 === false) {
                    $error = '<label style="color:red;">Error al preparar inserción en patient: ' . $database->error . '</label>';
                } else {
                    $stmt1->bind_param("sssssss", $email, $name, $newpassword, $address, $nic, $dob, $tele);
                    
                    if($stmt1->execute()) {
                        // INSERTAR en webuser
                        $stmt2 = $database->prepare("INSERT INTO webuser (email, usertype) VALUES (?, ?)");
                        if($stmt2 === false) {
                            $error = '<label style="color:red;">Error al preparar inserción en webuser: ' . $database->error . '</label>';
                        } else {
                            $usertype = 'p';
                            $stmt2->bind_param("ss", $email, $usertype);
                            
                            if($stmt2->execute()) {
                                // ÉXITO - establecer sesión y redirigir
                                $_SESSION["user"] = $email;
                                $_SESSION["usertype"] = "p";
                                $_SESSION["username"] = $fname;
                                
                                // Limpiar datos temporales
                                unset($_SESSION['personal']);
                                
                                header('Location: patient/index.php');
                                exit;
                            } else {
                                $error = '<label style="color:red;">Error al insertar en webuser: ' . $stmt2->error . '</label>';
                            }
                            $stmt2->close();
                        }
                    } else {
                        $error = '<label style="color:red;">Error al insertar en patient: ' . $stmt1->error . '</label>';
                    }
                    $stmt1->close();
                }
            }
            $stmt->close();
        }
    } else {
        $error = '<label style="color:red;">Las contraseñas no coinciden</label>';
    }
} else {
    $error = '<label></label>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
    <title>Create Account</title>
    <style>
        .container{
            animation: transitionIn-X 0.5s;
        }
        .error-message {
            color: red;
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <center>
    <div class="container">
        <table border="0" style="width: 69%;">
            <tr>
                <td colspan="2">
                    <p class="header-text">No estás solo:</p>
                    <p class="sub-text">Te ayudamos a encontrar el acompañamiento que necesitas</p>
                </td>
            </tr>
            
            <!-- Mostrar errores -->
            <?php if(isset($error) && $error != '<label></label>'): ?>
            <tr>
                <td colspan="2" class="error-message">
                    <?php echo str_replace(['<label style="color:red;">','</label>'], '', $error); ?>
                </td>
            </tr>
            <?php endif; ?>
            
            <tr>
                <form action="" method="POST">
                <td class="label-td" colspan="2">
                    <label for="newemail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="newemail" class="input-text" placeholder="Correo Electrónico" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="tele" class="form-label">Teléfono: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="tel" name="tele" class="input-text" placeholder="ej: 9531284327" pattern="[0-9]{10}" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="newpassword" class="form-label">Crea una nueva contraseña: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="newpassword" class="input-text" placeholder="Nueva contraseña" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="cpassword" class="form-label">Confirma tu contraseña: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="cpassword" class="input-text" placeholder="Confirma tu contraseña" required>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="reset" value="Limpiar" class="login-btn btn-primary-soft btn">
                </td>
                <td>
                    <input type="submit" value="Crear Cuenta" class="login-btn btn-primary btn">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">¿Ya tienes una cuenta? </label>
                    <a href="login.php" class="hover-link1 non-style-link"> Acceso</a>
                    <br><br><br>
                </td>
            </tr>
            </form>
        </table>
    </div>
    </center>
</body>
</html>
