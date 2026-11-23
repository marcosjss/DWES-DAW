<?php
const EMOJIS = ['😀', '😎', '😍', '🥳', '😺', '🐼', '🦊', '🐸', '🐵', '🐙'];

function emojisDisponibles (int $num) : array {
    return array_slice(EMOJIS, 0, max(0, $num));
}

function emojiAleatorio (array $emojis) : string {
    $indice = array_rand($emojis);
    return $emojis[$indice];
}

function validarContacto (array $c) : array {
    $errores = [];
    if (empty(trim($c['nombre'] ?? ''))) {
        $errores['nombre'] = 'El nombre es obligatorio.';
    }

    if (empty(trim($c['apellidos'] ?? ''))) {
        $errores['apellidos'] = 'Los apellidos son obligatorios.';
    }

    if (empty(trim($c['telefono'] ?? ''))) {
        $errores['telefono'] = 'El teléfono es obligatorio.';
    }

    if (empty(trim($c['email'] ?? ''))) {
        $errores['email'] = 'El email es obligatorio.';
    }

    $telefono = trim($c['telefono'] ?? '');
    if ($telefono !== '' && !preg_match('/^[0-9]{9}$/', $telefono)) {
        $errores['telefono'] = 'El teléfono debe tener 9 dígitos.';
    }

    $email = trim($c['email'] ?? '');
    if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errores['email'] = 'Introduce un email válido.';
    }
    return $errores;
}

function pintarFormularioContacto(int $i, string $emoji, array $valores, array $errores): string
{
    $nombre = (string)($valores['nombre'] ?? '');
    $apellidos = (string)($valores['apellidos'] ?? '');
    $telefono = (string)($valores['telefono'] ?? '');
    $email = (string)($valores['email'] ?? '');
    $emoji = ($emoji);

    return '<div>
        <p>Contacto ' . $i . ': ' . $emoji . '</p>
        <input type="hidden" name="contactos[' . $i . '][emoji]" value="' . $emoji . '">

        <p>Nombre: <input name="contactos[' . $i . '][nombre]" value="' . $nombre . '" required>
        ' . ($errores['nombre'] ?? '') . '</p>

        <p>Apellidos: <input name="contactos[' . $i . '][apellidos]" value="' . $apellidos . '" required>
        ' . ($errores['apellidos'] ?? '') . '</p>

        <p>Teléfono: <input name="contactos[' . $i . '][telefono]" value="' . $telefono . '" required>
        ' . ($errores['telefono'] ?? '') . '</p>

        <p>Email: <input name="contactos[' . $i . '][email]" value="' . $email . '" required>
        ' . ($errores['email'] ?? '') . '</p>
    </div>';
}