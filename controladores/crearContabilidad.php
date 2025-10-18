<?php
// controladores/crearContabilidad.php
include_once(__DIR__ . '/../config/conexion.php');

$sqls = [];
$sqls[] = "CREATE TABLE IF NOT EXISTS cuentas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) NOT NULL,
    nivel TINYINT DEFAULT 1,
    padre_id INT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$sqls[] = "CREATE TABLE IF NOT EXISTS asientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    descripcion VARCHAR(255),
    referencia VARCHAR(100),
    creado_por INT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$sqls[] = "CREATE TABLE IF NOT EXISTS asiento_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    asiento_id INT NOT NULL,
    cuenta_id INT NOT NULL,
    descripcion VARCHAR(255),
    debe DECIMAL(15,2) DEFAULT 0,
    haber DECIMAL(15,2) DEFAULT 0,
    FOREIGN KEY (asiento_id) REFERENCES asientos(id) ON DELETE CASCADE,
    FOREIGN KEY (cuenta_id) REFERENCES cuentas(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

foreach ($sqls as $sql) {
    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $conn->error . "\n";
    }
}

// Añadir columna 'total' a asientos si no existe
$colRes = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . $conn->real_escape_string($database) . "' AND TABLE_NAME = 'asientos' AND COLUMN_NAME = 'total'");
if ($colRes && $colRes->num_rows == 0) {
    $conn->query("ALTER TABLE asientos ADD COLUMN total DECIMAL(15,2) DEFAULT 0");
}

// Seed: crear algunas cuentas básicas si no existen
$seed = [
    ['1','1000','ACTIVOS','activo',1,null],
    ['2','2000','PASIVOS','pasivo',1,null],
    ['3','3000','PATRIMONIO','patrimonio',1,null],
    ['4','4000','INGRESOS','ingreso',1,null],
    ['5','5000','GASTOS','gasto',1,null],
];
$stmt = $conn->prepare("INSERT IGNORE INTO cuentas (id, codigo, nombre, tipo, nivel, padre_id) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($seed as $s) {
    $stmt->bind_param('isssii', $s[0], $s[1], $s[2], $s[3], $s[4], $s[5]);
    $stmt->execute();
}

echo "Tablas de contabilidad creadas y semillas insertadas.";

?>
