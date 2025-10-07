<?php    
    //import database
    include("../connection.php");

    // Iniciar buffer de salida
    ob_start();

    if($_POST){
        $name = $_POST['name'];
        $nic = $_POST['nic'];
        $oldemail = $_POST["oldemail"];
        $spec = $_POST['spec'];
        $email = $_POST['email'];
        $tele = $_POST['Tele'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $id = $_POST['id00'];
        
        // Validar que las contraseñas coincidan
        if ($password == $cpassword){
            $error = '3';
            
            // Verificar si el email ya existe en otro doctor
            $stmt = $database->prepare("SELECT docid FROM doctor WHERE docemail = ? AND docid != ?");
            $stmt->bind_param("si", $email, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows >= 1){
                $error = '1'; // Email ya existe
            } else {
                // Actualizar doctor
                $stmt1 = $database->prepare("UPDATE doctor SET docemail=?, docname=?, docpassword=?, docnic=?, doctel=?, specialties=? WHERE docid=?");
                $stmt1->bind_param("sssssii", $email, $name, $password, $nic, $tele, $spec, $id);
                $stmt1->execute();
                
                // Actualizar webuser
                $stmt2 = $database->prepare("UPDATE webuser SET email=? WHERE email=?");
                $stmt2->bind_param("ss", $email, $oldemail);
                $stmt2->execute();
                
                $error = '4'; // Éxito
            }
        } else {
            $error = '2'; // Contraseñas no coinciden
        }
    } else {
        $error = '3'; // No hay datos POST
    }

    // Limpiar buffer y redireccionar
    ob_end_clean();
    header("location: doctors.php?action=edit&error=".$error."&id=".$id);
    exit();
?>
