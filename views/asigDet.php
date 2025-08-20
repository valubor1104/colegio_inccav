<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asignaciones detalle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body style="background-color: #6d0d0d">
    <div class="container">
        <h1 class="text-center" style="background-color: #333; color: white">Asignaciones</h1>
    </div>
    <br>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Curso Asignado</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require '../config/conexion.php';

                // Cambia la consulta para incluir la información de la tabla curso
                $query = $conn->query("SELECT ad.curso1, ad.id_asig, c.descripcion as curso_descripcion, ea.estado as estado_curso
                           FROM asig_det ad
                           LEFT JOIN curso c ON ad.curso1 = c.id_curso
                           LEFT JOIN estado_alu ea ON ad.estado_curso = ea.id_estAlu
                           WHERE ad.id_asig = " . $_GET['Id']);

                while ($result = $query->fetch_assoc()) {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $result['curso_descripcion'] ?>
                        </th>
                        <th scope="row">
                            <?php echo $result['estado_curso'] ?>
                        </th>
                    </tr>
                    <?php
                }
                ?>
            </tbody>

        </table>
        <div class="container">
            <a href="../views/formasignacion.php" class="btn btn-dark">Volver Atras para imprimir</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>