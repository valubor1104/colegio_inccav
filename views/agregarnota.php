<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Insertar Calificaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color: #6d0d0d">
    <h1 class="bg-black p-2 text-white text-center">Agregar Notas</h1>
    <div class="container mt-5">
        <form action="../controladores/insertarnota.php" method="post">
            <label style="background-color: #6d0d0d; color: white" class="form-label">Seleccione alumno(*)</label>
            <br>
            <select class="form-select mb-3" name="carnet">
                <option selected disabled>---Seleccione alumno---</option>
                <?php
                include '../config/conexion.php';
                $sql = $conn->query("SELECT * FROM alumno;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['carnet'] . "'>" . $resultado['nombre'] . " " . $resultado['apellido'] . "</option>";
                }
                ?>
            </select>

            <label style="background-color: #6d0d0d; color: white" class="form-label">Seleccione semestre(*)</label>
            <br>
            <select class="form-select mb-3" name="semestre">
                <option selected disabled>---Seleccione semestre---</option>
                <?php
                $sql = $conn->query("SELECT * FROM grado;");
                while ($resultado = $sql->fetch_assoc()) {
                    echo "<option value='" . $resultado['id'] . "'>" . $resultado['grado'] . "</option>";
                }
                ?>
            </select>

            <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="mb-3">
                    <label style="background-color: #6d0d0d; color: white" class="form-label">Curso
                        <?= $i ?>:
                    </label>
                    <select class="form-select mb-3" name="curso<?= $i ?>">
                        <option selected disabled>---Seleccione curso---</option>
                        <?php
                        $sql = $conn->query("SELECT * FROM curso;");
                        while ($resultado = $sql->fetch_assoc()) {
                            echo "<option value='" . $resultado['id_curso'] . "'>" . $resultado['descripcion'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label style="background-color: #6d0d0d; color: white" class="form-label">Nota
                        <?= $i ?>:
                    </label>
                    <input type="text" class="form-control" name="nota<?= $i ?>">
                </div>

            <?php endfor; ?>

            <div class="text-center">
                <button type="submit" class="btn btn-danger">Registrar</button>
                <a href="../views/menu_principal.php" class="btn btn-dark">Volver Atrás</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>