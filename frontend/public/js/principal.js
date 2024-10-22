document.addEventListener('DOMContentLoaded', function() {
    const cambiarPasswordBtn = document.getElementById('cambiar-password');
    const soporteChatBtn = document.getElementById('soportechat');
    const principalContainer = document.getElementById('principal-container');

    // Función para cargar contenido en el contenedor
    function loadContent(url) {
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                principalContainer.innerHTML = data; // Cargar contenido en el contenedor

                // Inicializar el chat solo si se cargó la vista de soporte chat
                if (url === '/soportechat') {
                    initializeChat(); // Llama a la función que inicializa el chat
                }
            })
            .catch(error => console.error('Error al cargar la vista:', error));
    }

    cambiarPasswordBtn.addEventListener('click', function() {
        loadContent('/cambiarcontraseña'); // Cambia a la vista de cambiar contraseña
    });

    soporteChatBtn.addEventListener('click', function() {
        loadContent('/soportechat'); // Cambia a la vista de soporte chat
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
            });
        }
    }
});
