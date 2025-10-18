<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asignacion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body style="background-color: #6d0d0d">
    <div class="container">
        <h1 class="text-center" style="background-color: #333; color: white">Edicion de asignaciones</h1>
        <form action="../controladores/editAsig.php" method="POST">
            <?php
            include '../config/conexion.php';
            $sql = "SELECT * FROM asignacion WHERE id_asig =" . $_GET['Id'];
            $resultado = $conn->query($sql);

            $row = $resultado->fetch_assoc();
            ?>

            <input type="Hidden" class="form-control" name="Id" value="<?php echo $row['id_asig']; ?>">

            <!--se traen datos grado--->


            
            <label style="background-color: #6d0d0d; color: white" class="form-label">Seleccione Grado (*)
            </label>
            <select class="form-select mb-3" name="semestre">
                <option selected disabled>---seleccionar grado---</option>
                <?php

                include '../config/conexion.php';
                $sql1 = "SELECT * FROM grado WHERE id =" . $row['semestre'];
                $resultado1 = $conn->query($sql1);
                $row1 = $resultado1->fetch_assoc();
                echo "<option selected value='" . $row1['id'] . "'>" . $row1['grado'] . "</option>";

                $sql2 = "SELECT * FROM grado";
                $resultado2 = $conn->query($sql2);

                while ($fila = $resultado2->fetch_array()) {
                    echo "<option value='" . $fila['id'] . "'>" . $fila['grado'] . "</option>";
                }
                ?>
            </select>

            <label style="background-color: #6d0d0d; color: white" class="form-label">Seleccione salon (*)
            </label>
            <select class="form-select mb-3" name="noSalon">
                <option selected disabled>---seleccionar salon y sector---</option>
                <?php

                include '../config/conexion.php';
                $sql1 = "SELECT * FROM salon WHERE no_salon =" . $row['noSalon'];
                $resultado1 = $conn->query($sql1);
                $row1 = $resultado1->fetch_assoc();
                echo "<option selected value='" . $row1['no_salon'] . "'>" . $row1['no_salon'] . " " . $row1['sector'] . "</option>";

                $sql2 = "SELECT * FROM salon";
                $resultado2 = $conn->query($sql2);

                while ($fila = $resultado2->fetch_array()) {
                    echo "<option value='" . $fila['no_salon'] . "'>" . $fila['no_salon'] . " " . $fila['sector'] . "</option>";
                }
                ?>
            </select>
            <div class="text-center">
                <button type="submit" class="btn btn-danger">Modificar</button>
                <a href="formasignacion.php" class="btn btn-dark">Volver Atras</a>
        </div>
        </form>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>