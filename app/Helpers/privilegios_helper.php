<?php

function tienePermiso($accion, $seccion)
{
    $rol = session()->get('rol_usuario');

    $permisos = [
        'Admin' => [
            'libros' => ['ver', 'crear', 'editar', 'eliminar'],
            'prestamos' => ['ver', 'crear', 'editar', 'eliminar'],
            'usuarios' => ['ver', 'crear', 'editar', 'eliminar', 'ver_contraseña'],
        ],
        'Bibliotecario' => [
            'libros' => ['ver', 'crear', 'editar', 'eliminar'],
            'prestamos' => ['ver', 'crear', 'editar', 'eliminar'],
            'usuarios' => ['ver'],
        ],
        'Alumno' => [
            'libros' => ['ver'],
            'prestamos' => ['ver_historial'],
        ],
    ];

    return in_array($accion, $permisos[$rol][$seccion] ?? []);
}
