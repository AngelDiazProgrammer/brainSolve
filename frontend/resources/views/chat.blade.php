<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <title>Chat</title>
</head>
<body>

<div id="box-img">
    <img id="robert" src="{{ asset('img/robert.png') }}" alt="">
</div>
<h2>Hola, soy Robert, bienvenido, {{ $nombre_usuario }}</h2>
<div id="chat-messages">
    <!-- Aquí se mostrarán los mensajes del chat -->
</div>

<div id="typing-indicator" style="display: none;">
    <span id="dots">...</span>
</div>

<form id="message-form">
    @csrf
    <input type="text" id="message-input" placeholder="Escribe tu mensaje...">
    <button type="submit" id="send-button">Enviar</button>
</form>

<script src="{{ asset('js/chat.js') }}"></script>
</body>
</html>
