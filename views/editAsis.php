<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asistencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body style="background-color: #6d0d0d">
    <div class="container">
        <h1 class="text-center" style="background-color: #333; color: white">Cambiar estado de asistencia</h1>
        <form action="../controladores/editaAsis.php" method="POST">
            <?php
            include '../config/conexion.php';
            $sql = "SELECT * FROM asistencia WHERE id_asis =" . $_GET['Id'];
            $resultado = $conn->query($sql);

            $row = $resultado->fetch_assoc();
            ?>

            <input type="Hidden" class="form-control" name="Id" value="<?php echo $row['id_asis']; ?>">

            <!--se traen datos grado--->
            <label style="background-color: #6d0d0d; color: white" class="form-label">Estado del estudiante(*)</label>
            <br>
            <select class="form-select mb-3" name="estado">
                <option selected disabled>---seleccionar estado---</option>
                <?php

                include '../config/conexion.php';
                $sql3 = "SELECT * FROM colegio.estado_asis WHERE id_estAsis =" . $row['estado'];
                $resultado3 = $conn->query($sql3);
                $row3 = $resultado3->fetch_assoc();
                echo "<option selected value='" . $row3['id_estAsis'] . "'>" . $row3['estado'] . "</option>";

                $sql4 = "SELECT * FROM colegio.estado_asis";
                $resultado4 = $conn->query($sql4);

                while ($fila = $resultado4->fetch_array()) {
                    echo "<option value='" . $fila['id_estAsis'] . "'>" . $fila['estado'] . "</option>";
                }


                ?>
            </select>
            <div class="text-center">
                <button type="submit" class="btn btn-danger">Modificar</button>
                <a href="../views/formAsistencia.php" class="btn btn-dark">Volver Atras</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>