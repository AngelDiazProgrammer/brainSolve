// public/js/chat.js

document.getElementById('message-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var prompt = document.getElementById('message-input').value;
    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Mostrar "Escribiendo..." mientras se espera la respuesta
    var typingIndicator = document.getElementById('typing-indicator');
    typingIndicator.style.display = 'block'; // Mostrar el indicador

    fetch('/generate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ prompt: prompt }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok.');
        }
        return response.json();
    })
    .then(data => {
        // Ocultar "Escribiendo..." y mostrar respuesta
        typingIndicator.style.display = 'none';

        // Agregar el mensaje generado al chat
        var chatMessages = document.getElementById('chat-messages');
        chatMessages.innerHTML += '<div class="message">' + data.generated_text + '</div>';

        // Limpiar el campo de entrada después de enviar el mensaje
        document.getElementById('message-input').value = '';
    })
    .catch(error => {
        console.error('Error al procesar la solicitud:', error);
        typingIndicator.style.display = 'none'; // Ocultar en caso de error
    });
});
console.log('Prompt:', prompt);
console.log('Token:', token);
