// public/js/chat.js

document.getElementById('message-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var prompt = document.getElementById('message-input').value;
    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Obtener el token CSRF

    // Realizar la solicitud a la API Flask
    fetch('/generate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token // Agregar el token CSRF al encabezado
        },
        body: JSON.stringify({ prompt: prompt }),
    })
    .then(response => response.json())
    .then(data => {
        // Mostrar la respuesta generada en el chat
        var chatMessages = document.getElementById('chat-messages');
        chatMessages.innerHTML += '<div class="message">' + data.generated_text + '</div>';

        // Limpiar el campo de entrada después de enviar el mensaje
        document.getElementById('message-input').value = '';
    })
    .catch(error => {
        console.error('Error al procesar la solicitud:', error);
    });
});
