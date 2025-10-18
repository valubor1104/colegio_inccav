<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body style="background-color: #6d0d0d">
    <div class="container">
        <h1 class="text-center" style="background-color: #333; color: white">Edicion de alumnos</h1>
        <form action="../controladores/editCurso.php" method="POST">
            <?php
            include '../config/conexion.php';
            $sql = "SELECT * FROM curso WHERE id_curso =" . $_GET['Id'];
            $resultado = $conn->query($sql);

            $row = $resultado->fetch_assoc();
            ?>

            <input type="Hidden" class="form-control" name="Id" value="<?php echo $row['id_curso']; ?>">

            <!--se traen datos grado--->


            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">ID del curso(*)</label>
                <input type="text" class="form-control" name="idCurso" value="<?php echo $row['id_curso']; ?>">
            </div>
            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Nombre del curso(*)</label>
                <input type="text" class="form-control" name="nombreCurso" value="<?php echo $row['descripcion']; ?>">
            </div>
            <label style="background-color: #6d0d0d; color: white" class="form-label">Catedratico que lo imparte(*)</label>
            <br>
            <select class="form-select mb-3" name="id_cat">
                <option selected disabled>---seleccionar catedratico---</option>
                 <?php

                include '../config/conexion.php';
                $sql1 = "SELECT * FROM catedratico WHERE id_cat =" . $row['id_cat'];
                $resultado1 = $conn->query($sql1);
                $row1 = $resultado1->fetch_assoc();
                echo "<option selected value='" . $row1['id_cat'] . "'>" . $row1['nombre'] . " " . $row1['apellido'] . "</option>";

                $sql2 = "SELECT * FROM catedratico";
                $resultado2 = $conn->query($sql2);
                while ($fila = $resultado2->fetch_array()) {
                   echo "<option value='" . $fila['id_cat'] . "'>" . $fila['nombre'] . " " . $fila['apellido'] . "</option>";
                }

                ?>
            </select>
            <div class="text-center">
                <button type="submit" class="btn btn-danger">Modificar</button>
                <a href="formcurso.php" class="btn btn-dark">Volver Atras</a>
        </div>
        </form>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>