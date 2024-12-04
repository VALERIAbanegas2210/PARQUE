<!-- resources/views/emails/verification-success.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación Exitosa</title>
</head>

<body>
    <h1>¡Registro Exitoso!</h1>
    <p>Tu cuenta ha sido verificada con éxito.</p>
    <p>Serás redirigido al login en 10 segundos...</p>

    <script>
        setTimeout(function() {
            window.location.href = "{{ route('administracion.login') }}"; // Redirige a la página de login
        }, 10000); // Espera 10 segundos
    </script>
</body>

</html>
