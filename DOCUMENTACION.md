# Documentación del sistema - Colegio Prado

Fecha: 17 de octubre de 2025

Este documento resume la estructura, módulos, catálogos y comportamiento principal del proyecto "colegio".

## Resumen general

Aplicación web desarrollada en PHP (procedural) con MySQL (XAMPP). Contiene módulos administrativos para gestión de usuarios, alumnos, cursos, asignaciones, notas, planillas y un subsistema contable (cuentas, asientos) y bancario (cuentas bancarias, movimientos y cheques).

## Requisitos

- PHP (XAMPP) en Windows
- MySQL / MariaDB
- Navegador moderno

## Estructura de carpetas relevante

- `config/` — configuraciones y `conexion.php` (conexión a la base de datos).
- `controladores/` — lógica del lado servidor, endpoints y acciones POST/GET.
- `views/` — páginas y formularios que usa la aplicación.
- `estilos/` — hojas de estilo CSS.
- `library/`, `pdf/`, `scripts/` — utilidades, exportes y scripts auxiliares.

## Módulos principales

A continuación se listan los módulos implementados y una breve descripción de cada archivo/controlador relevante.

### 1) Usuarios y Sesiones

- Objetivo: gestión de usuarios, login, logout y roles.
- Vistas principales:
  - `views/formUser.php` — formulario de gestión de usuarios.
  - `views/agregarUser.php` — crear nuevo usuario.
  - `views/logout.php` — cerrar sesión.
- Controladores relevantes: `controladores/insertarUser.php`, `controladores/editUser.php`, `controladores/eliminarUser.php`, `controladores/editUser.php`.

### 2) Registros académicos (Alumnos, Cursos, Grados, Especialidades, Salones)

- Objetivo: CRUD para datos maestros de la institución.
- Vistas: `formalumno.php`, `formsalon.php`, `formcurso.php`, `formgrados.php`, `formcatedratico.php`, etc.
- Controladores: `insertarAlu.php`, `editAlu.php`, `eliminarAlu.php`, y sus homólogos para cursos, grados, especialidades y salones.

### 3) Asignaciones, Asistencia y Notas

- Objetivo: manejo de asignaciones de catedráticos a cursos, registro de asistencia y de notas.
- Vistas: `formsignacion.php`, `formAsistencia.php`, `formnota.php`, `agregarAsistencia.php`.
- Controladores: `insertarAsig.php`, `insertarAsistencia.php`, `insertarnota.php`, `editAsig.php`.

### 4) Planillas (nomina / planilla)

- Objetivo: CRUD para la tabla `planilla` (gestion de planillas de pago o planilla de registros que el sistema usa).
- Vistas: `agregarPlanilla.php`, `planillaLista.php`, `editarPlanilla.php`.
- Controladores: `insertarPlanilla.php`, `listarPlanilla.php`, `editarPlanilla.php`, `eliminarPlanilla.php`.

### 5) Contabilidad

- Objetivo: llevar asientos contables y cuentas.
- Controladores:
  - `controladores/asientos.php` — crea/lista/edita asientos (registra `asientos` y `asiento_items`).
  - `controladores/cuentas.php` — CRUD de cuentas contables.
- Vistas:
  - `views/asientosLista.php`, `views/asientoCrear.php`, `views/asientoEditar.php`.
  - `views/cuentasLista.php`, `views/cuentasCrear.php`, `views/cuentasEditar.php`.
- Notas: el módulo de contabilidad guarda el campo `total` en la tabla `asientos` (suma de debe/haber) para facilitar listados.


### 6) Metodos de Pago

- Script: `controladores/crearMetodosPago.php` — crea la tabla `metodos_pago` y la poblada con métodos comunes.

## Catálogos y tablas importantes

- `usuarios` — gestión de acceso y roles.
- `alumnos`, `cursos`, `grados`, `especialidades`, `salones` — catálogos académicos.
- `planilla` — planillas (estructura y uso según vistas relacionadas).
- `cuentas` / `asientos` / `asiento_items` — contabilidad básica.
- `metodos_pago` — catálogo de medios de cobro/pago.

## Flujo típico de uso (ejemplos)

1. Crear usuario/roles -> Registrar datos maestros (alumnos, cursos, grados) -> Crear asignaciones.
2. Registrar asientos en Contabilidad: ir a "Asientos" -> Nuevo -> agregar líneas Debe/Haber -> guardar. El total se persiste.
datos del banco y de la cuenta.


## Notas técnicas y recomendaciones

- Validaciones críticas: para cheques se valida en servidor que Debe == Haber y que la suma de las líneas equivale al valor del cheque.
- Transacciones: las operaciones multi-tabla (crear asientos y movimientos) usan transacciones para mantener integridad.
- Correlativos: el flujo actual incrementa `correlativo_actual` en la creación de cheques, aunque el formulario unificado permite crear banco+cuenta sin forzar correlativos.

