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
    <h1 class="bg-black p-2 text-white text-center">Asignar alumno</h1>
    <br>
    <div class="container">
        <form action="../controladores/insertarAsig.php" method="POST">
            <label style="background-color: #6d0d0d; color: white" class="form-label">seleccione alumno a asignar(*)</label>
            <br>
            <select class="form-select mb-3" name="carnet">
                <option selected disabled>---seleccionar alumno a asignar---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM colegio.alumno;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['carnet'] . "'>" . $resultado['nombre'] . " " . $resultado['apellido'] . "</option>";
                }
                ?>
            </select>
            <label style="background-color: #6d0d0d; color: white" class="form-label">seleccione semestre(*)</label>
            <br>
            <select class="form-select mb-3" name="semestre">
                <option selected disabled>---seleccione semestre a cursar---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM colegio.grado;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['id'] . "'>" . $resultado['grado'] . "</option>";
                }
                ?>
            </select>
            <label style="background-color: #6d0d0d; color: white" class="form-label">seleccione salon(*)</label>
            <br>
            <select class="form-select mb-3" name="noSalon">
                <option selected disabled>---seleccione salon y sector a asignar ---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM colegio.salon;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['no_salon'] . "'>" . $resultado['no_salon'] . " " . $resultado['sector'] . "</option>";
                    
                }
                ?>
            </select>
            <br>
            <label style="background-color: #6d0d0d; color: white" class="form-label">curso 1 (*)</label>
            <select class="form-select mb-3" name="curso1">
                <option selected disabled>---seleccione curso a asignar ---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM colegio.curso;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['id_curso'] . "'>" . $resultado['descripcion'] . "</option>";
                    
                }
                ?>
            </select>
            <label style="background-color: #6d0d0d; color: white" class="form-label">curso 2(*)</label>
            <br>
            <select class="form-select mb-3" name="curso2">
                <option selected disabled>---seleccione curso a asignar ---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM colegio.curso;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['id_curso'] . "'>" . $resultado['descripcion'] . "</option>";
                    
                }
                ?>
            </select>
            <label style="background-color: #6d0d0d; color: white" class="form-label">curso 3(*)</label>
            <br>
            <select class="form-select mb-3" name="curso3">
                <option selected disabled>---seleccione curso a asignar ---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM colegio.curso;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['id_curso'] . "'>" . $resultado['descripcion'] . "</option>";
                    
                }
                ?>
            </select>
            <label style="background-color: #6d0d0d; color: white" class="form-label">curso 4(*)</label>
            <br>
            <select class="form-select mb-3" name="curso4">
                <option selected disabled>---seleccione curso a asignar ---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM colegio.curso;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['id_curso'] . "'>" . $resultado['descripcion'] . "</option>";
                    
                }
                ?>
            </select>
            <label style="background-color: #6d0d0d; color: white" class="form-label">curso 5(*)</label>
            <br>
            <select class="form-select mb-3" name="curso5">
                <option selected disabled>---seleccione curso a asignar ---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM colegio.curso;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['id_curso'] . "'>" . $resultado['descripcion'] . "</option>";
                    
                }
                ?>
            </select>
            <label style="background-color: #6d0d0d; color: white" class="form-label">curso 6(*)</label>
            <br>
            <select class="form-select mb-3" name="curso6">
                <option selected disabled>---seleccione curso a asignar ---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM colegio.curso;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['id_curso'] . "'>" . $resultado['descripcion'] . "</option>";
                    
                }
                ?>
            </select>
            <div class="text-center">
            <button type="submit" class="btn btn-danger">Registrar</button>
           <a href="formasignacion.php" class="btn btn-dark">Volver Atras</a>
            </div>
        </form>
    </div>
    <br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>