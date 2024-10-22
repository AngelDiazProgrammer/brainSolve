<div id="chat-messages">
    <!-- Aquí se mostrarán los mensajes del chat -->
</div>
<div>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
<div id="typing-indicator" style="display: none;">
    <span id="dots">...</span>
</div>

<form id="message-form">
    @csrf
    <input type="text" id="message-input" placeholder="Escribe tu mensaje...">
    <button type="submit" id="send-button">Enviar</button>
</form>
</div>
