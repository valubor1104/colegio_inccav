<?php
require '../config/conexion.php';

    //$idespec = $_POST['IdEspec'];
    $Desc = $_POST['desc'];
    
    $sql = $conn->prepare("INSERT INTO especialidad (descripcion) VALUES(?)");

    if(!$sql){
        die ("Error al preparar la consulta".$conn->error);
    }
$sql -> bind_param("s", $Desc);

$resultado = $sql -> execute();

$sql->close();
$conn->close();


 /* $query = "insert into colegio_inccav.especialidad(id_espec, descripcion) 
    values('" . $idespec . "', '" . $Desc . "')";
    $resultado = mysqli_query($conn, $query);
    if ($resultado == 1) {
    echo '
				<script language="javascript">
					alert("Registro creado correctamente");
					window.location.replace("../views/especialidades.php");
				</script>
			';
    } else {
    echo '
				<script language="javascript">
					alert("Error al  crear el registro");
					window.location.replace("../views/especialidades.php");
				</script>
			';
    }*/

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <script>
        Swal.fire({
            title: "<?php echo $resultado ? 'Éxito' : 'Error'; ?>",
            html: "<?php echo $resultado ? '<strong>Registro agregado correctamente!</strong><br> Desea volver al formulario?'
                        : '<strong>Error al:</strong>' . $conn->error . '<br> Desea volver al formulario?'; ?>",
            icon: "<?php echo $resultado ? 'success' : 'error'; ?>",
            confirmButtonText: "Desea ir al listado?",
            denyButtonText: "Desea agregar otro registro?",
            showDenyButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "../views/especialidades.php";
            } else {
                //window.history.back();
                window.location = "../views/agregarEspec.php"
            }
        })
    </script>

</body>
</html>
