<?php
require_once __DIR__ . '/../config/conexion.php';
// `config/conexion.php` crea la variable $conn
// asegurarse de que $conn existe
if (!isset($conn)) {
  die('No hay conexión a la base de datos. Revisar config/conexion.php');
}

$sql = "
CREATE TABLE IF NOT EXISTS bancos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  codigo VARCHAR(50) DEFAULT NULL,
  creado_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS cuentas_bancarias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  banco_id INT NOT NULL,
  numero VARCHAR(100) NOT NULL,
  numero_cuenta VARCHAR(100) DEFAULT NULL,
  codigo VARCHAR(50) DEFAULT NULL,
  descripcion VARCHAR(255),
  moneda VARCHAR(10) DEFAULT 'GTQ',
  titular VARCHAR(255) DEFAULT NULL,
  correlativo_inicial INT DEFAULT NULL,
  correlativo_final INT DEFAULT NULL,
  correlativo_actual INT DEFAULT 0,
  saldo DECIMAL(15,2) DEFAULT 0.00,
  creado_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (banco_id) REFERENCES bancos(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS movimientos_bancarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cuenta_bancaria_id INT NOT NULL,
  fecha DATETIME NOT NULL,
  tipo ENUM('ingreso','egreso') NOT NULL,
  monto DECIMAL(15,2) NOT NULL,
  descripcion VARCHAR(255),
  referencia VARCHAR(100),
  creado_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (cuenta_bancaria_id) REFERENCES cuentas_bancarias(id) ON DELETE CASCADE
);
";

if ($conn->multi_query($sql)) {
    do { /* vacía para avanzar */ } while ($conn->more_results() && $conn->next_result());
    echo "Tablas de bancos creadas o ya existían.";
} else {
    echo "Error creando tablas: " . $conn->error;
}

// Asegurar columnas adicionales si la tabla ya existía
$alter = "";
$res = $conn->query("SHOW COLUMNS FROM cuentas_bancarias LIKE 'numero_cuenta'");
if (!$res || $res->num_rows == 0) $alter .= "ALTER TABLE cuentas_bancarias ADD COLUMN numero_cuenta VARCHAR(100) DEFAULT NULL;";
$res = $conn->query("SHOW COLUMNS FROM cuentas_bancarias LIKE 'codigo'");
if (!$res || $res->num_rows == 0) $alter .= "ALTER TABLE cuentas_bancarias ADD COLUMN codigo VARCHAR(50) DEFAULT NULL;";
$res = $conn->query("SHOW COLUMNS FROM cuentas_bancarias LIKE 'titular'");
if (!$res || $res->num_rows == 0) $alter .= "ALTER TABLE cuentas_bancarias ADD COLUMN titular VARCHAR(255) DEFAULT NULL;";
$res = $conn->query("SHOW COLUMNS FROM cuentas_bancarias LIKE 'correlativo_inicial'");
if (!$res || $res->num_rows == 0) $alter .= "ALTER TABLE cuentas_bancarias ADD COLUMN correlativo_inicial INT DEFAULT NULL, ADD COLUMN correlativo_final INT DEFAULT NULL, ADD COLUMN correlativo_actual INT DEFAULT 0;";
if ($alter != "") {
  if ($conn->multi_query($alter)) {
    do { } while ($conn->more_results() && $conn->next_result());
    echo "Columnas adicionales aseguradas.\n";
  } else {
    echo "Error al alterar cuentas_bancarias: " . $conn->error . "\n";
  }
}

$conn->close();

?>
