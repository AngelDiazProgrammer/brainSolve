<div>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <h2>Cambia tu contraseña</h2>
    <div id="chat-messages">
        <span>Por favor ingresa tu usuario de red</span>
        <!-- Aquí se mostrarán los mensajes del chat -->
    </div>

    <div id="typing-indicator" style="display: none;">
        <span id="dots">...</span>
    </div>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/cambiar-contraseña') }}" method="POST">
        @csrf
        <div>
            <label for="username">Nombre de usuario:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="new_password">Nueva contraseña:</label>
            <input type="password" id="new_password" name="new_password" required minlength="8">
        </div>
        <div>
            <button type="submit">Cambiar Contraseña</button>
        </div>
    </form>
