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
        <div id="box-img"><img id="robert" src="{{ asset('img/Lucy.png') }}" alt=""></div>
        <div id="bienvenida"><p>Bienvenido {{ $nombre_usuario }}</p></div>
        <div id="cerrar-sesion">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit"><p>Cerrar Sesion</p></button>
            </form>
        </div>
    </nav>

    <div id="principal-container" class="container">
        <div id="box-img-principal"><img id="robert" src="{{ asset('img/LucyP.png') }}" alt=""></div>

        <!-- Nuevo contenedor de tarjetas -->
        <div id="card-container">
            <div class="card"><button id="cambiar-password">Cambiar Contraseña</button></div>
            <div class="card"><button id="soportechat">Soporte Chat</button></div>
            <div class="card"><button id="entrenamiento">Entrenamiento</button></div>
            <div class="card"><button id="rollback">Version Rollback</button></div>
        </div>
    </div>

    <script src="{{ asset('js/principal.js') }}"></script>
    <script src="{{ asset('js/chat.js') }}"></script>


</body>
</html>
