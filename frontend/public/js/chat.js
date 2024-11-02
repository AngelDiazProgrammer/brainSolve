//Enter en el chat
document.getElementById('message-input').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault(); // Previene el comportamiento predeterminado del Enter
        document.getElementById('message-form').dispatchEvent(new Event('submit')); // Envía el formulario
    }
});

document.getElementById('message-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el envío del formulario
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();

    if (message) {
        // Aquí va la lógica para enviar el mensaje (por ejemplo, AJAX o Fetch)
        console.log(message); //imprime el mensaje en la consola

        // Limpia el campo de entrada
        messageInput.value = '';
    }
});


// Función para inicializar el chat
function initializeChat() {
    const form = document.getElementById('message-form');
    if (form) { // Asegúrate de que el formulario exista
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto

            const input = document.getElementById('message-input');
            const message = input.value;
            if (message) {
                // Lógica para enviar el mensaje
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Obtener el token CSRF
                fetch('/generate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token // Agregar el token CSRF al encabezado
                    },
                    body: JSON.stringify({ prompt: message }),
                })
                .then(response => response.json())
                .then(data => {
                    const chatMessages = document.getElementById('chat-messages');
                    chatMessages.innerHTML += '<div class="message">' + data.generated_text + '</div>'; // Agregar el mensaje generado al chat
                    input.value = ''; // Limpiar el campo de entrada
                })
                .catch(error => console.error('Error al procesar la solicitud:', error));
            }
        })}};
