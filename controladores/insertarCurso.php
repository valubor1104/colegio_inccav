<?php
require '../config/conexion.php';

/*$query = "insert into colegio_inccav.curso(descripcion, id_Cat) 
    values('" . $nombrecurso . "', '" . $idCatC . "')";
    $resultado = mysqli_query($conn, $query);
    if ($resultado == 1) {
    echo '
				<script language="javascript">
					alert("Registro creado correctamente");
					window.location.replace("../views/formcurso.php");
				</script>
			';
    } else {
    echo '
				<script language="javascript">
					alert("Error al  crear el registro");
					window.location.replace("../views/formcurso.php");
				</script>
			';
    }*/

$nombrecurso = $_POST['nombreCurso'];
$idCatC = $_POST['idCat'];

$sql = $conn->prepare("INSERT INTO curso (descripcion, id_Cat) VALUES (?,?) ");

if (!$sql) {
    die("Error al preparar la consulta" . $conn->error);
}

$sql->bind_param("si", $nombrecurso, $idCatC);

$resultado = $sql->execute();

$sql->close();
$conn->close();

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
                window.location = "../views/formcurso.php";
            } else {
                //window.history.back();
                window.location = "../views/agregarCurso.php"
            }
        })
    </script>

</body>
</html>