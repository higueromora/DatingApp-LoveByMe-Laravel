// Función para cargar el estado de los mensajes sin leer
function loadUnreadMessages() {
    // Realizar una petición AJAX para verificar si hay mensajes sin leer
    fetch('/check-unread-messages')
        .then(response => response.json())
        .then(data => {
            // Actualizar la visualización del mensaje pendiente para cada usuario
            data.unreadMessages.forEach(userId => {
                const unreadMessage = document.getElementById('unread-message-' + userId);
                if (unreadMessage) {
                    if (data.unreadMessages.includes(userId)) {
                        // Si hay mensajes sin leer, mostrar el mensaje pendiente
                        unreadMessage.style.display = 'block';
                    } else {
                        // Si no hay mensajes sin leer, ocultar el mensaje pendiente
                        unreadMessage.style.display = 'none';
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error al cargar los mensajes sin leer:', error);
        });
}

// Llamar a la función inicialmente al cargar la página
loadUnreadMessages();

// Configurar la actualización periódica cada 2 segundos
setInterval(loadUnreadMessages, 2000);