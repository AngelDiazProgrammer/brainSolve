<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/principal.css') }}">
    <title>Lucy</title>
</head>
<body>
    <nav>
        <div id="box-img"><img id="robert" src="{{ asset('img/robert.png') }}" alt=""></div>
        <div id="bienvenida"><p>Bienvenido {{ $nombre_usuario }}</p></div>
        <div id="cerrar-sesion"><button><p>Cerrar Sesion</p></button></div>
    </nav>

    <div class="container" id="bar-left">
        <p><button id="cambiar-password">Cambiar Contraseña</button></p>
        <p><button id="soportechat">Soporte Chat</button></p>
    </div>

    <div id="principal-container" class="container">
        <!-- Aquí se cargará el contenido de las vistas -->
    </div>

    <script src="{{ asset('js/principal.js') }}"></script>
</body>
</html>
