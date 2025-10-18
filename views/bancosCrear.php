<?php include_once(__DIR__ . '/../controladores/bancos.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Banco</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Nuevo Banco</h2>
        <form method="post" action="../controladores/bancos.php">
            <input type="hidden" name="action" value="create_bank_with_account">
            <h3>Datos del banco</h3>
            <label>Nombre</label>
            <input type="text" name="nombre" required>
            <label>Código</label>
            <input type="text" name="codigo">

            <h3>Crear cuenta bancaria asociada</h3>
            <label>No. Cuenta</label>
            <input type="text" name="numero_cuenta" required>
            <label>Descripción</label>
            <input type="text" name="descripcion">
            <label>Moneda</label>
            <input type="text" name="moneda" value="GTQ">
            <label>Titular</label>
            <input type="text" name="titular">
            <label>Saldo inicial</label>
            <input type="number" step="0.01" name="saldo" value="0.00">

            <div style="margin-top:10px">
                <button class="btn-primary" type="submit">Crear banco y cuenta</button>
                <a class="btn-secondary" href="bancosLista.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
