<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Definir el token CSRF -->
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <title>Document</title>
</head>
<body>
    <h2>Hola, soy Robert, bienvenido, {{ $nombre_usuario }}</h2>


<!-- resources/views/chat.blade.php -->

<div id="chat-messages">
    <!-- Aquí se mostrarán los mensajes del chat -->
</div>

<form id="message-form">
    @csrf <!-- Agrega el token CSRF -->
    <input type="text" id="message-input" placeholder="Escribe tu mensaje...">
    <button type="submit" id="send-button">Enviar</button>
</form>


<script src="{{ asset('js/chat.js') }}"></script>
</body>
</html>

