<?php

session_start();

$_SESSION["user"]="";
$_SESSION["usertype"]="";

date_default_timezone_set('America/Mexico_City');
$date = date('Y-m-d');

$_SESSION["date"]=$date;



if($_POST){
    // Validaciones básicas
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $address = trim($_POST['address']);
    $nic = trim($_POST['nic']);
    $dob = $_POST['dob'];
    
    // Validar que no estén vacíos
    if(empty($fname) || empty($lname) || empty($address) || empty($nic) || empty($dob)) {
        $error = '<label style="color:red;text-align:center;">Todos los campos son obligatorios</label>';
    }
    // Validar fecha de nacimiento (no puede ser futura)
    else if(strtotime($dob) > time()) {
        $error = '<label style="color:red;text-align:center;">La fecha de nacimiento no puede ser futura</label>';
    }
    // Validar CURP (formato básico: 4 letras, 6 números, 6 letras, 2 caracteres)
    else if(!preg_match('/^[A-Za-z]{4}[0-9]{6}[A-Za-z]{6}[0-9A-Za-z]{2}$/', $nic)) {
        $error = '<label style="color:red;text-align:center;">Formato de CURP inválido (4 letras, 6 números, 6 letras, 2 caracteres)</label>';
    }
    else {
        $_SESSION["personal"]=array(
            'fname'=>$fname,
            'lname'=>$lname,
            'address'=>$address,
            'nic'=>$nic,
            'dob'=>$dob
        );

     header("location: create-account.php");
        exit;

    }
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
        
    <title>Sign Up</title>
    
</head>
<body>
    <center>
    <div class="container">
        <table border="0">
            <tr>
                <td colspan="2">
                    <p class="header-text">Crea tu cuenta</p>
                    <p class="sub-text">Y empieza a cuidar tu bienestar emocional</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST" >
                <td class="label-td" colspan="2">
                    <label for="name" class="form-label">Nombre: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="text" name="fname" class="input-text" placeholder="Primer Nombre" required>
                </td>
                <td class="label-td">
                    <input type="text" name="lname" class="input-text" placeholder="Apellidos" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="address" class="form-label">Domicilio: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="address" class="input-text" placeholder="Domicilio" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="nic" class="form-label">CURP: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="nic" class="input-text" placeholder="Ingresa tu curp" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="dob" class="form-label">Natalicio: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="date" name="dob" class="input-text" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                </td>
            </tr>

            <tr>
                <td>
                    <input type="reset" value="Limpiar" class="login-btn btn-primary-soft btn" >
                </td>
                <td>
                    <input type="submit" value="Siguiente" class="login-btn btn-primary btn">
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;"> ¿Ya tienes una cuenta&#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link"> Acceso</a>
                    <br><br><br>
                </td>
            </tr>

                    </form>
            </tr>
        </table>

    <?php if(isset($error)): ?>
            <div style="margin-top: 20px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>


    </div>
</center>
</body>
</html>
