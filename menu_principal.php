<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php"); // redirige si no está logueado
    exit;
}

$rol = $_SESSION['rol']; // rol del usuario
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menu Principal</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
</head>
<body style="background-image: url('./imagenes/fondo1.jpg'); background-size: cover;">
<nav>
    <ul class="menu-horizontal">
        <?php if ($rol == 1 || $rol == 2): // Admin y Catedrático ?>
        <li><a href="#">Usuarios</a>
            <ul class="menu-vertical">

				<?php if ($rol == 1): // Solo Administrador ?>
				<li><a href="./views/agregarUser.php">Crear Usuarios</a></li>
                <li><a href="./views/formUser.php">Gestión de Usuarios</a></li>
                <li><a href="index.php?views=logout" class="btn btn-dark">Cerrar Sesion</a>
				<?php endif; ?>

				<?php if ($rol == 2): // Solo Catedrático ?>
				<li><a href="index.php?views=logout" class="btn btn-dark">Cerrar Sesion</a>
				<?php endif; ?>
				
            </ul>
        </li>
        <?php endif; ?>

        <?php if ($rol == 1 || $rol == 2): // Admin y Catedrático ?>
        <li><a href="#">Asignación</a>
			<ul class="menu-vertical">
				<?php if ($rol == 1): // Solo Administrador ?>
				<li><a href="./views/formasignacion.php">Asignación de cursos</a></li>
				<li><a href="./views/formcobros.php">Cobros</a></li>
				<li><a href="./views/formAsistencia.php">Asistencia</a></li>
				<li><a href="./views/formnota.php">Notas</a></li>
				<?php endif; ?>

				<?php if ($rol == 2): // Solo Catedrático ?>
				<li><a href="./views/formAsistencia.php">Asistencia</a></li>
				<li><a href="./views/formnota.php">Notas</a></li>
				<?php endif; ?>
			</ul>
		</li>

        <?php endif; ?>

        <?php if ($rol == 1): // Solo admin ?>
        <li><a href="#">Registros</a>
            <ul class="menu-vertical">
                <li><a href="./views/formalumno.php">Alumnos</a></li>
                <li><a href="./views/formcatedratico.php">Catedráticos</a></li>
                <li><a href="./views/formcurso.php">Cursos</a></li>
                <li><a href="./views/especialidades.php">Especialidades</a></li>
                <li><a href="./views/formgrados.php">Grados</a></li>
                <li><a href="./views/formsalon.php">Salones</a></li>
            </ul>
        </li>
        <?php endif; ?>
    </ul>
</nav>
</body>
</html>
