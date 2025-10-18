<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body style="background-color: #6d0d0d">
    <div class="container">
        <h1 class="text-center" style="background-color: #333; color: white">Edicion de usuarios</h1>
        <form action="../controladores/editUser.php" method="POST">
            <?php
            include '../config/conexion.php';
            $sql = "SELECT * FROM usuario WHERE id_usuario =" . $_GET['Id'];
            $resultado = $conn->query($sql);

            $row = $resultado->fetch_assoc();
            ?>

            <input type="Hidden" class="form-control" name="Id" value="<?php echo $row['id_usuario']; ?>">

            <!--se traen datos grado--->


            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $row['nombre']; ?>">
            </div>
            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Nombre de usuario(*)</label>
                <input type="text" class="form-control" name="user" value="<?php echo $row['nombre_usuario']; ?>">
            </div>
            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">clave(*)</label>
                <input type="password" class="form-control" name="clave" value="<?php echo $row['clave']; ?>">
            </div>
            <label style="background-color: #6d0d0d; color: white" class="form-label">Seleccione el rol del usuario(*)</label>
            <select class="form-select mb-3" name="rol">
                <option selected disabled>---seleccionar rol---</option>
                <?php

                include '../config/conexion.php';
                $sql1 = "SELECT * FROM rol WHERE id_rol =" . $row['rol'];
                $resultado1 = $conn->query($sql1);
                $row1 = $resultado1->fetch_assoc();
                echo "<option selected value='" . $row1['id_rol'] . "'>" . $row1['rol'] . "</option>";

                $sql2 = "SELECT * FROM rol";
                $resultado2 = $conn->query($sql2);

                while ($fila = $resultado2->fetch_array()) {
                    echo "<option value='" . $fila['id_rol'] . "'>" . $fila['rol'] . "</option>";
                }


                ?>
            </select>
            <div class="text-center">
                <button type="submit" class="btn btn-danger">Modificar</button>
                <a href="formUser.php" class="btn btn-dark">Volver Atras</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>