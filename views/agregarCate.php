<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar Catedratico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body style="background-color: #6d0d0d">
    <h1 class="bg-black p-2 text-white text-center">Agregar Catedratico</h1>
    <br>
    <div class="container">
        <form action="../controladores/insertarCate.php" method="POST">
            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Ingrese el Nombre(*)</label>
                <input type="text" class="form-control" name="nombre">
            </div>
            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Ingrese el Apellido(*)</label>
                <input type="text" class="form-control" name="apellido">
            </div>
            <label style="background-color: #6d0d0d; color: white" class="form-label">Seleccione en que se especializa el catedratico</label>
            <select class="form-select mb-3" name="espec">
                <option selected disabled>---seleccionar especialidad---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM colegio.especialidad;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['id_espec'] . "'>" . $resultado['descripcion'] . "</option>";
                }
                ?>
            </select>
            <label style="background-color: #6d0d0d; color: white" class="form-label">Estado del catedratico(*)</label>
            <br>
            <select class="form-select mb-3" name="estado">
                <option selected disabled>---seleccionar estado---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM colegio.estado_catedra;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['id_estCate'] . "'>" . $resultado['estado'] . "</option>";
                }
                ?>
            </select>
            <div class="text-center">
            <button type="submit" class="btn btn-danger">Registrar</button>
           <a href="formcatedratico.php" class="btn btn-dark">Volver Atras</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>