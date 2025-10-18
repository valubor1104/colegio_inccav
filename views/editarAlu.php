<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- jQuery UI CSS para estilos de autocomplete -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        /* Mejorar visibilidad del menú autocomplete */
        .ui-autocomplete {
            background: #ffffff;
            color: #111111;
            border: 1px solid #bfcad6;
            max-height: 240px;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.4);
            z-index: 20000 !important;
            font-size: 14px;
            padding: 4px 0;
            border-radius: 6px;
        }
        .ui-autocomplete .ui-menu-item-wrapper{
            padding: 6px 12px;
            cursor: pointer;
        }
        .ui-menu-item-wrapper.ui-state-active,
        .ui-menu-item-wrapper.ui-state-focus{
            background: #1f4e79;
            color: #fff;
        }
        /* Asegurar que el input destaque cuando se selecciona */
        #estado_texto{
            background: #fff;
            color: #111;
            border-radius: 6px;
        }
    </style>
</head>

<body style="background-color: #6d0d0d">
    <div class="container">
        <h1 class="text-center" style="background-color: #333; color: white">Edición de alumnos</h1>
        <form action="../controladores/editAlu.php" method="POST">
            <?php
            include '../config/conexion.php';
            $carnetParam = isset($_GET['Id']) ? $_GET['Id'] : 0;
            $row = array();
            // Usar consulta preparada que trae también el nombre del estado (si existe)
            // Si el usuario DB no tiene permisos sobre la tabla estado_alu, la preparación puede lanzar una excepción.
            try {
                $stmt = $conn->prepare("SELECT a.*, e.estado AS estado_nombre FROM alumno a LEFT JOIN estado_alu e ON a.estado = e.id_estAlu WHERE a.carnet = ?");
            } catch (mysqli_sql_exception $ex) {
                error_log('DB prepare failed (editarAlu.php): ' . $ex->getMessage());
                $stmt = false;
            }
            if ($stmt) {
                $stmt->bind_param('i', $carnetParam);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $stmt->close();
            } else {
                // Fallback: intentar traer solo la fila de alumno (sin JOIN). Si falla, la página seguirá sin estado precargado.
                try {
                    $safeId = intval($carnetParam);
                    $res2 = $conn->query("SELECT * FROM alumno WHERE carnet = " . $safeId);
                    if ($res2) {
                        $row = $res2->fetch_assoc();
                    }
                } catch (Exception $e) {
                    error_log('Fallback query failed (editarAlu.php): ' . $e->getMessage());
                    $row = array();
                }
            }
            ?>

            <input type="Hidden" class="form-control" name="Id" value="<?php echo $row['carnet']; ?>">

            <!--se traen datos grado--->


            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Carnet(*)</label>
                <input type="text" class="form-control" name="carnet" value="<?php echo $row['carnet']; ?>">
            </div>
            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Nombre(*)</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $row['nombre']; ?>">
            </div>
            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Apellido(*)</label>
                <input type="text" class="form-control" name="apellido" value="<?php echo $row['apellido']; ?>">
            </div>
            <div class="mb-3">
                <label style="background-color: #6d0d0d; color: white" class="form-label">Observaciones(*)</label>
                <input type="text" class="form-control" name="descripcion" value="<?php echo $row['descripcion']; ?>">
            </div>
            <label style="background-color: #6d0d0d; color: white" class="form-label">Estado del estudiante(*)</label>
            <br>
            <!-- Campo autocomplete para estado, guarda id en campo oculto -->
            <?php
            $estadoId = isset($row['estado']) ? intval($row['estado']) : 0;
            $estadoText = isset($row['estado_nombre']) ? $row['estado_nombre'] : '';
            ?>
            <input type="text" class="form-control mb-2" id="estado_texto" placeholder="Escriba para buscar estado..." value="<?php echo htmlspecialchars($estadoText, ENT_QUOTES); ?>">
            <input type="hidden" name="estado" id="estado" value="<?php echo $estadoId > 0 ? $estadoId : ''; ?>">
            <div class="text-center">
                <button type="submit" class="btn btn-danger">Modificar</button>
                <a href="formalumno.php" class="btn btn-dark">Volver Atras</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <!-- jQuery y jQuery UI para autocomplete -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $("#estado_texto").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "../controladores/busca_estados.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            termino: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.label,
                                    value: item.label,
                                    id: item.id
                                };
                            }));
                        }
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    $("#estado").val(ui.item.id);
                }
            });
            // Validación antes de submit: asegurarse que #estado tenga un id numérico
            // Si el usuario escribe pero no selecciona (no dispara select), intentar resolver en blur
            $("#estado_texto").on('blur', function(){
                var texto = $(this).val().trim();
                var hidden = $("#estado").val();
                if(texto !== '' && (!hidden || hidden == '')){
                    $.ajax({
                        url: "../controladores/busca_estados.php",
                        type: "POST",
                        dataType: "json",
                        data: { termino: texto },
                        success: function(data){
                            if(data && data.length === 1){
                                $("#estado").val(data[0].id);
                            } else if (data && data.length > 1){
                                // buscar coincidencia exacta por label (case-insensitive)
                                var found = null;
                                for(var i=0;i<data.length;i++){
                                    if(data[i].label.toLowerCase() === texto.toLowerCase()){
                                        found = data[i]; break;
                                    }
                                }
                                if(found){ $("#estado").val(found.id); }
                            }
                        }
                    });
                }
            });

            $("form").on('submit', function(e){
                var estadoVal = $("#estado").val();
                var texto = $("#estado_texto").val().trim();
                var form = this;
                if(!estadoVal || isNaN(parseInt(estadoVal))){
                    e.preventDefault();
                    // intentar resolver con AJAX antes de pedir selección manual
                    if(texto === ''){
                        alert('Por favor seleccione un estado válido desde la lista.');
                        $("#estado_texto").focus();
                        return false;
                    }
                    $.ajax({
                        url: "../controladores/busca_estados.php",
                        type: "POST",
                        dataType: "json",
                        data: { termino: texto },
                        success: function(data){
                            if(data && data.length >= 1){
                                // priorizar coincidencia exacta
                                var found = null;
                                for(var i=0;i<data.length;i++){
                                    if(data[i].label.toLowerCase() === texto.toLowerCase()){
                                        found = data[i]; break;
                                    }
                                }
                                if(!found) found = data[0];
                                if(found){
                                    $("#estado").val(found.id);
                                    // enviar de nuevo el formulario (sin reentrar en este handler)
                                    $(form).off('submit');
                                    form.submit();
                                    return;
                                }
                            }
                            alert('No se encontró un estado válido. Seleccione una opción de la lista.');
                            $("#estado_texto").focus();
                        },
                        error: function(){
                            alert('Error al validar el estado. Intenta de nuevo.');
                        }
                    });
                    return false;
                }
                return true;
            });
        });
    </script>
</body>

</html>