<link rel="stylesheet" href="{{ asset('css/general.css') }}">

    <!-- Contenedor para el botón de Dashboard -->
<div class="card" style="margin-bottom: 20px;">
    <button id="dashboard-button" onclick="window.location.href='{{ route('principal') }}'">Dashboard</button>
</div>
<!-- Contenedor principal -->
<div id="chat-container">


    <!-- Contenedor para la imagen y el chat -->
    <div style="display: flex; align-items: flex-start;">
        <!-- Imagen -->
        <div id="box-img-chat">
            <img id="robert" src="{{ asset('img/Lucy.png') }}" alt="">
        </div>

        <!-- Contenedor del chat -->
        <div id="chat-messages">
            <!-- Aquí se mostrarán los mensajes del chat -->
        </div>
    </div>
</div>

<div>
    <div id="typing-indicator" style="display: none;">
        <span id="dots">...</span>
    </div>

    <form id="message-form">
        @csrf
        <input type="text" id="message-input" placeholder="Escribe tu mensaje..." autocomplete="off">
    </form>
</div>

