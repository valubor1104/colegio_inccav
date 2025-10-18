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
    <h1 class="bg-black p-2 text-white text-center">Creacion de usuarios</h1>
    <br>
    <div class="container">
        <form action="../controladores/insertarUser.php" method="POST">
            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Ingrese el Nombre(*)</label>
                <input type="text" class="form-control" name="nombre">
            </div>
            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Ingrese el nombre de usuario(*)</label>
                <input type="text" class="form-control" name="user">
            </div>
            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Ingrese la contraseña(*)</label>
                <input type="password" class="form-control" name="clave">
            </div>
            <label style="background-color: #6d0d0d; color: white" class="form-label">Seleccione el rol de usuario</label>
            <select class="form-select mb-3" name="rol">
                <option selected disabled>---seleccionar rol---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM rol;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['id_rol'] . "'>" . $resultado['rol'] . "</option>";
                }
                ?>
            </select>
            <div class="text-center">
            <button type="submit" class="btn btn-danger">Registrar</button>
           <a href="../menu_principal.php" class="btn btn-dark">Volver Atras</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>