<?php
// controladores/bancos.php
include_once(__DIR__ . '/../config/conexion.php');

// Listar bancos
$bancos = [];
$res = $conn->query("SELECT * FROM bancos ORDER BY nombre ASC");
if ($res) while ($r = $res->fetch_assoc()) $bancos[] = $r;

// Listar cuentas bancarias (opcional por banco)
$cuentas = [];
if (isset($_GET['bank_id'])) {
    $bank_id = (int)$_GET['bank_id'];
    $stmt = $conn->prepare("SELECT cb.*, b.nombre as banco_nombre FROM cuentas_bancarias cb LEFT JOIN bancos b ON cb.banco_id = b.id WHERE cb.banco_id = ? ORDER BY cb.id ASC");
    $stmt->bind_param('i', $bank_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($r = $res->fetch_assoc()) $cuentas[] = $r;
} else {
    $res = $conn->query("SELECT cb.*, b.nombre as banco_nombre FROM cuentas_bancarias cb LEFT JOIN bancos b ON cb.banco_id = b.id ORDER BY b.nombre, cb.id");
    if ($res) while ($r = $res->fetch_assoc()) $cuentas[] = $r;
}

// Listar movimientos para una cuenta
$movimientos = [];
if (isset($_GET['cuenta_id'])) {
    $cuenta_id = (int)$_GET['cuenta_id'];
    $stmt = $conn->prepare("SELECT m.*, cb.numero_cuenta as cuenta_numero FROM movimientos_bancarios m LEFT JOIN cuentas_bancarias cb ON m.cuenta_bancaria_id = cb.id WHERE m.cuenta_bancaria_id = ? ORDER BY m.fecha DESC");
    $stmt->bind_param('i', $cuenta_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($r = $res->fetch_assoc()) $movimientos[] = $r;
}

// Crear banco
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_bank') {
    $nombre = $_POST['nombre'];
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;
    $stmt = $conn->prepare("INSERT INTO bancos (nombre, codigo) VALUES (?, ?)");
    $stmt->bind_param('ss', $nombre, $codigo);
    if ($stmt->execute()) header('Location: ../views/bancosLista.php?msg=created'); else header('Location: ../views/bancosCrear.php?msg=error');
    exit;
}

// Crear banco + cuenta en una transacción
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_bank_with_account') {
    $nombre = $_POST['nombre'];
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;
    $numero_cuenta = $_POST['numero_cuenta'];
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
    $moneda = isset($_POST['moneda']) ? $_POST['moneda'] : 'GTQ';
    $titular = isset($_POST['titular']) ? $_POST['titular'] : null;
    $saldo = isset($_POST['saldo']) ? (float)$_POST['saldo'] : 0.00;

    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("INSERT INTO bancos (nombre, codigo) VALUES (?, ?)");
        $stmt->bind_param('ss', $nombre, $codigo); $stmt->execute();
        $banco_id = $conn->insert_id;

        $st2 = $conn->prepare("INSERT INTO cuentas_bancarias (banco_id, numero_cuenta, numero, descripcion, moneda, titular, saldo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        // numero reused as the same stored number
        $st2->bind_param('isssssd', $banco_id, $numero_cuenta, $numero_cuenta, $descripcion, $moneda, $titular, $saldo);
        $st2->execute();

        $conn->commit();
        header('Location: ../views/cuentasBancariasLista.php?bank_id=' . $banco_id . '&msg=created'); exit;
    } catch (Exception $e) {
        $conn->rollback();
        header('Location: ../views/bancosCrear.php?msg=error'); exit;
    }
}

// Crear cuenta bancaria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_account') {
    $banco_id = (int)$_POST['banco_id'];
    // el input en la vista se llama numero_cuenta
    $numero = isset($_POST['numero_cuenta']) ? $_POST['numero_cuenta'] : $_POST['numero'];
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
    $moneda = isset($_POST['moneda']) ? $_POST['moneda'] : 'GTQ';
    $saldo = isset($_POST['saldo']) ? (float)$_POST['saldo'] : 0.00;

    $stmt = $conn->prepare("INSERT INTO cuentas_bancarias (banco_id, numero, descripcion, moneda, saldo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('isssd', $banco_id, $numero, $descripcion, $moneda, $saldo);
    if ($stmt->execute()) header('Location: ../views/cuentasBancariasLista.php?bank_id=' . $banco_id . '&msg=created'); else header('Location: ../views/cuentasBancariasCrear.php?msg=error');
    exit;
}

// Eliminar banco
if (isset($_GET['action']) && $_GET['action'] === 'delete_bank' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM bancos WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: ../views/bancosLista.php?msg=deleted'); exit;
}

// Eliminar cuenta bancaria
if (isset($_GET['action']) && $_GET['action'] === 'delete_account' && isset($_GET['id']) && isset($_GET['bank_id'])) {
    $id = (int)$_GET['id'];
    $bank_id = (int)$_GET['bank_id'];
    $stmt = $conn->prepare("DELETE FROM cuentas_bancarias WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: ../views/cuentasBancariasLista.php?bank_id=' . $bank_id . '&msg=deleted'); exit;
}

// Crear movimiento bancario (usa transacción y actualiza saldo)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_mov') {
    $cuenta_id = (int)$_POST['cuenta_id'];
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo']; // 'ingreso'|'egreso'
    $monto = (float)$_POST['monto'];
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
    $referencia = isset($_POST['referencia']) ? $_POST['referencia'] : null;

    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("INSERT INTO movimientos_bancarios (cuenta_bancaria_id, fecha, tipo, monto, descripcion, referencia) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('issdss', $cuenta_id, $fecha, $tipo, $monto, $descripcion, $referencia);
        $stmt->execute();

        // Actualizar saldo
        if ($tipo === 'ingreso') {
            $stmt2 = $conn->prepare("UPDATE cuentas_bancarias SET saldo = saldo + ? WHERE id = ?");
            $stmt2->bind_param('di', $monto, $cuenta_id);
        } else {
            $stmt2 = $conn->prepare("UPDATE cuentas_bancarias SET saldo = saldo - ? WHERE id = ?");
            $stmt2->bind_param('di', $monto, $cuenta_id);
        }
        $stmt2->execute();
        $conn->commit();
        header('Location: ../views/movimientosLista.php?cuenta_id=' . $cuenta_id . '&msg=created'); exit;
    } catch (Exception $e) {
        $conn->rollback();
        header('Location: ../views/movimientosCrear.php?cuenta_id=' . $cuenta_id . '&msg=error'); exit;
    }
}

// Crear cheque (asiento + movimiento + actualizar saldo + correlativo)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_cheque') {
    $cuenta_id = (int)$_POST['cuenta_id'];
    $fecha = $_POST['fecha'];
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $valor = (float)$_POST['valor'];
    $concepto = isset($_POST['concepto']) ? $_POST['concepto'] : null;
    $lines = json_decode($_POST['lines'], true);

    // validaciones básicas
    if ($valor <= 0) { header('Location: ../views/chequesCrear.php?msg=El valor debe ser mayor a 0'); exit; }
    if (!is_array($lines) || count($lines) === 0) { header('Location: ../views/chequesCrear.php?msg=Debe agregar líneas contables'); exit; }

    // validar sumas Debe == Haber y que la suma coincida con valor
    $sumDebe = 0; $sumHaber = 0; foreach ($lines as $l) { $sumDebe += (float)$l['debe']; $sumHaber += (float)$l['haber']; }
    if (round($sumDebe,2) !== round($sumHaber,2)) { header('Location: ../views/chequesCrear.php?msg=Totales Debe/Haber no coinciden'); exit; }
    // Aceptar que el valor sea igual a cualquiera de los totales (usualmente total debe == valor)
    if (round($valor,2) !== round($sumDebe,2) && round($valor,2) !== round($sumHaber,2)) { header('Location: ../views/chequesCrear.php?msg=La suma de líneas no coincide con el valor'); exit; }

    $conn->begin_transaction();
    try {
        // lock cuenta
        $stmt = $conn->prepare("SELECT correlativo_actual, correlativo_final, saldo FROM cuentas_bancarias WHERE id = ? FOR UPDATE");
        $stmt->bind_param('i', $cuenta_id); $stmt->execute();
        $res = $stmt->get_result();
        if (!($row = $res->fetch_assoc())) throw new Exception('Cuenta no encontrada');

        // crear asiento
        $descripcion = 'Cheque: ' . $nombre . ' ' . $numero;
        $total = 0; foreach ($lines as $l) { $total += ($l['debe'] + $l['haber']); }
        $stmt = $conn->prepare("INSERT INTO asientos (fecha, descripcion, referencia, total) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sssd', $fecha, $descripcion, $numero, $valor); $stmt->execute();
        $asiento_id = $conn->insert_id;

        foreach ($lines as $l) {
            $cu = $l['cuenta']; $desc = $l['desc']; $debe = (float)$l['debe']; $haber = (float)$l['haber'];
            $st = $conn->prepare("INSERT INTO asiento_items (asiento_id, cuenta_codigo, descripcion, debe, haber) VALUES (?, ?, ?, ?, ?)");
            $st->bind_param('issdd', $asiento_id, $cu, $desc, $debe, $haber); $st->execute();
        }

        // crear movimiento bancario y actualizar saldo (asumiendo egreso)
        $stmt = $conn->prepare("INSERT INTO movimientos_bancarios (cuenta_bancaria_id, fecha, tipo, monto, descripcion, referencia) VALUES (?, ?, 'egreso', ?, ?, ?)");
        $stmt->bind_param('isdds', $cuenta_id, $fecha, $valor, $concepto, $numero); $stmt->execute();

        // actualizar saldo
        $u = $conn->prepare("UPDATE cuentas_bancarias SET saldo = saldo - ?, correlativo_actual = correlativo_actual + 1 WHERE id = ?");
        $u->bind_param('di', $valor, $cuenta_id); $u->execute();

        $conn->commit();
        header('Location: ../views/movimientosLista.php?cuenta_id=' . $cuenta_id . '&msg=created'); exit;
    } catch (Exception $e) {
        $conn->rollback();
        header('Location: ../views/chequesCrear.php?msg=error'); exit;
    }
}

// Eliminar movimiento (revierte saldo y borra)
if (isset($_GET['action']) && $_GET['action'] === 'delete_mov' && isset($_GET['id']) && isset($_GET['cuenta_id'])) {
    $id = (int)$_GET['id'];
    $cuenta_id = (int)$_GET['cuenta_id'];
    // Obtener movimiento
    $stmt = $conn->prepare("SELECT tipo, monto FROM movimientos_bancarios WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $tipo = $row['tipo'];
        $monto = (float)$row['monto'];
        $conn->begin_transaction();
        try {
            // reversar saldo
            if ($tipo === 'ingreso') {
                $u = $conn->prepare("UPDATE cuentas_bancarias SET saldo = saldo - ? WHERE id = ?");
                $u->bind_param('di', $monto, $cuenta_id);
            } else {
                $u = $conn->prepare("UPDATE cuentas_bancarias SET saldo = saldo + ? WHERE id = ?");
                $u->bind_param('di', $monto, $cuenta_id);
            }
            $u->execute();
            $d = $conn->prepare("DELETE FROM movimientos_bancarios WHERE id = ?");
            $d->bind_param('i', $id);
            $d->execute();
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
        }
    }
    header('Location: ../views/movimientosLista.php?cuenta_id=' . $cuenta_id . '&msg=deleted'); exit;
}

?>
