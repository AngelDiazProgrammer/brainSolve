document.addEventListener('DOMContentLoaded', function() {
    const cambiarPasswordBtn = document.getElementById('cambiar-password');
    const soporteChatBtn = document.getElementById('soportechat');
    const entrenamientoChatBtn = document.getElementById('entrenamiento');
    const rollbacChatkBtn = document.getElementById('rollback');
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

    entrenamientoChatBtn.addEventListener('click',function(){
        loadContent('/train');// Cambiar a la vista de entrenamiento del chat
    });
    rollbacChatkBtn.addEventListener('click', function(){
        loadContent('/rollback');//cambiar a la vista para restaurar una version del chat
    });



});
