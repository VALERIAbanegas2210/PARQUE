<!-- resources/views/ruta/show.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Ruta</title>
</head>
<body>
    <h1>Detalles de la Ruta</h1>

    <p><strong>Nombre de la Ruta:</strong> {{ $ruta->nombre }}</p>
    <p><strong>Comunidad Asociada:</strong> {{ $ruta->comunidad->nombre }}</p> <!-- Cambiado a comunidad->nombre -->
</body>
</html>

