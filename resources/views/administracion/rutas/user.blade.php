<!-- resources/views/administracion/rutas/user.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rutas Disponibles</title>
</head>
<body>
    <h1>Rutas Disponibles</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Comunidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rutas as $ruta)
                <tr>
                    <td>{{ $ruta->id }}</td>
                    <td>{{ $ruta->nombre }}</td>
                    <td>{{ $ruta->comunidad->nombre }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
