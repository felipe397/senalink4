<?php
require_once '../models/UsuarioModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos base del formulario
    $correo         = $_POST['correo'] ?? null;
    $contrasena     = $_POST['contrasena'] ?? null;
    $rol            = $_POST['rol'] ?? 'Empresa'; // por defecto
    $fecha_creacion = date('Y-m-d H:i:s');
    $estado         = 'activo';

    // Datos adicionales
    $nickname            = $_POST['nickname'] ?? null;
    $nombres             = $_POST['nombres'] ?? null;
    $apellidos           = $_POST['apellidos'] ?? null;
    $nit                 = $_POST['nit'] ?? null;
    $actividad_economica = $_POST['actividad_economica'] ?? null;
    $direccion           = $_POST['direccion'] ?? null;
    $nombre_empresa      = $_POST['nombre_empresa'] ?? null;
    $telefono            = $_POST['telefono'] ?? null;
    $tipo_documento      = $_POST['tipo_documento'] ?? null;
    $numero_documento    = $_POST['numero_documento'] ?? null;

    // Validación mínima
    if (!$correo || !$contrasena) {
        echo "Correo y contraseña son obligatorios.";
        exit;
    }

    if (UsuarioModel::existeCorreo($correo)) {
        echo "Este correo ya está registrado.";
        exit;
    }

    if ($nickname && UsuarioModel::existeNickname($nickname)) {
        echo "Este nickname ya existe.";
        exit;
    }

    // Hash seguro de contraseña
    $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);

    // Array de datos para insertar
    $datos = [
        'tipo_documento'        => $tipo_documento,
        'numero_documento'      => $numero_documento,
        'nombres'               => $nombres,
        'apellidos'             => $apellidos,
        'nickname'              => $nickname,
        'correo'                => $correo,
        'contrasena'            => $hashedPassword,
        'rol'                   => $rol,
        'estado'                => $estado,
        'fecha_creacion'        => $fecha_creacion,
        'nit'                   => $nit,
        'actividad_economica'   => $actividad_economica,
        'direccion'             => $direccion,
        'nombre_empresa'        => $nombre_empresa,
        'telefono'              => $telefono
    ];

    // Crear usuario
    $resultado = UsuarioModel::crear($datos);

    if ($resultado) {
        header('Location: ../views/login.php?registro=exito');
        exit;
    } else {
        echo "Error al crear usuario.";
        exit;
    }
}
