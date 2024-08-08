<?php
// Contraseña para proteger el acceso al formulario
define('PASSWORD', 'mateouma1421');

// Verifica si la contraseña es correcta
if ($_POST['password'] !== PASSWORD) {
    die('Contraseña incorrecta');
}

// Ruta del archivo JSON donde se guardarán los eventos
$archivo_eventos = 'eventos.json';

// Recoge los datos del formulario
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];

// Procesa la imagen si se subió
$imagen = null;
if ($_FILES['imagen']['name']) {
    $nombre_imagen = basename($_FILES['imagen']['name']);
    $ruta_imagen = 'imagenes_eventos/' . $nombre_imagen;
    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen);
    $imagen = $ruta_imagen;
}

// Cargar eventos existentes
$eventos = [];
if (file_exists($archivo_eventos)) {
    $eventos = json_decode(file_get_contents($archivo_eventos), true);
}

// Añadir nuevo evento
$eventos[] = [
    'titulo' => $titulo,
    'descripcion' => $descripcion,
    'imagen' => $imagen
];

// Guardar eventos actualizados
file_put_contents($archivo_eventos, json_encode($eventos));

// Redirigir a la página de eventos
header('Location: eventos.html');
exit();
?>
