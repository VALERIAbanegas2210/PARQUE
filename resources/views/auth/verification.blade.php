<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Código</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Aquí va tu CSS existente */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .verification-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .code-inputs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .code-inputs input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 24px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .code-inputs input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 8px rgba(59, 130, 246, 0.5);
        }

        button {
            background-color: #3b82f6;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2563eb;
        }

        .error-messages {
            color: #e3342f;
            margin-top: 20px;
        }

        .error-messages p {
            margin: 5px 0;
        }

        .success-message {
            color: green;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="verification-container">
        <h1>Verificación de Código</h1>

        <form method="POST" action="{{ route('verification.submit') }}">
            @csrf
            <input type="hidden" name="email" value="{{ request('email') }}">

            <div class="code-inputs">
                <input type="text" name="code[]" maxlength="1" required>
                <input type="text" name="code[]" maxlength="1" required>
                <input type="text" name="code[]" maxlength="1" required>
                <input type="text" name="code[]" maxlength="1" required>
                <input type="text" name="code[]" maxlength="1" required>
                <input type="text" name="code[]" maxlength="1" required>
            </div>

            <button type="submit">Verificar</button>
        </form>

        @if (session('success'))
            <div class="success-message">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="error-messages">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        // Obtener todos los inputs del código
        const inputs = document.querySelectorAll('.code-inputs input');

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                // Si se ha ingresado un valor, pasar al siguiente input
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                // Si se borra un valor, volver al input anterior
                if (input.value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            // Permitir solo caracteres numéricos
            input.addEventListener('keydown', (e) => {
                const key = e.key;
                if (key !== 'Backspace' && (isNaN(key) || key === ' ')) {
                    e.preventDefault();
                }
            });
        });

        // Redirección después de mostrar el mensaje de éxito
        @if (session('success'))
            setTimeout(() => {
                window.location.href = "{{ route('administracion.login') }}";
            }, 2000); // 10 segundos
        @endif
    </script>
</body>

</html>
