// Lógica para enviar el mensaje al presionar 'Enter'
document.getElementById('message-input').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault(); // Previene el comportamiento por defecto
        document.getElementById('message-form').dispatchEvent(new Event('submit')); // Enviar el formulario
    }
});

// Función para inicializar el chat
function initializeChat() {
    const form = document.getElementById('message-form');
    if (form) { // Asegúrate de que el formulario exista
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto

            const input = document.getElementById('message-input');
            const message = input.value.trim();

            if (message) {
                // Mostrar el mensaje del usuario inmediatamente
                addMessageToChat(message, 'user');

                // Limpiar el campo de entrada
                input.value = '';

                // Generar respuesta del bot mediante fetch
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Obtener el token CSRF
                fetch('/generate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token // Agregar el token CSRF al encabezado
                    },
                    body: JSON.stringify({ prompt: message })
                })
                .then(response => response.json())
                .then(data => {
                    // Agregar la respuesta del bot al chat
                    addMessageToChat(data.generated_text, 'bot');
                })
                .catch(error => console.error('Error al procesar la solicitud:', error));
            }
        });
    }
}

// Función para agregar mensajes al chat
function addMessageToChat(message, sender) {
    const chatMessages = document.getElementById('chat-messages');

    // Crear un nuevo elemento de mensaje
    const messageElement = document.createElement('p');
    messageElement.classList.add('message', sender); // 'user' o 'bot'
    messageElement.textContent = message;

    // Agregar el mensaje al contenedor
    chatMessages.appendChild(messageElement);

    // Desplazar al final del chat para mostrar el último mensaje
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Inicializa el chat al cargar la página
initializeChat();
