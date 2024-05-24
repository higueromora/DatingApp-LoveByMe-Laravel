/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');

var url = 'http://social-app.com.devel';

window.addEventListener("load",function(){
    // Boton de like
    function like(){
        $('.btn-like').unbind('click').click(function(){
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url+'/img/like.svg');

            $.ajax({
                url: url+'/like/'+ $(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('Has dado like a la publicación')
                    }else{
                        console.log('Error al dar like')
                    }
                }
            });

            dislike();
        });
    }
    like();

    

    // Boton de dislike
    function dislike(){
        $('.btn-dislike').unbind('click').click(function(){
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src',url+'/img/like2.svg');

            $.ajax({
                url: url+'/dislike/'+ $(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('Has dado dislike a la publicación')
                    }else{
                        console.log('Error al dar dislike')
                    }
                }
            });

            like();
        });
    }
    dislike();


    // Boton de like
    function likematch(){
        $('.btn-likematch').unbind('click').click(function(){
            $(this).addClass('btn-dislikematch').removeClass('btn-likematch');
            $(this).attr('src', url+'/img/LikeMatch.svg');

            $.ajax({
                url: url+'/likematch/'+ $(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('Has dado match')
                    }else{
                        console.log('Error al dar match')
                    }
                }
            });

            dislikematch();
        });
    }
    likematch();

    // Boton de dislikeMatch
    function dislikematch(){
        $('.btn-dislikematch').unbind('click').click(function(){
            $(this).addClass('btn-likematch').removeClass('btn-dislikematch');
            $(this).attr('src',url+'/img/like2.svg');

            $.ajax({
                url: url+'/dislikematch/'+ $(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('Has dado dismatch')
                    }else{
                        console.log('Error al dar dismatch')
                    }
                }
            });

            likematch();
        });
    }
    dislikematch();


    //Buscador
    $('#buscador').submit(function(){
        $(this).attr('action',url+'/gente/'+$('#buscador #search').val());
    });

    // Buscador match
    $('#buscadormatch').submit(function(){
        $(this).attr('action', url + '/match/' + $('#search').val());
    });


});


// El editar descripción del perfil
// $(document).ready(function(){
//     $('#edit-profile-description').click(function(){
//         $('#profile-description-form').toggle();
//     });
// });

$(document).ready(function(){
    $('#edit-profile-description').click(function(event){
        event.stopPropagation(); // Evita que el clic se propague al elemento padre y no cierre el formulario
        $('#profile-description-form').toggle();
        $('body').toggleClass('dimmed');
        $('.profile-description').toggleClass('no-dimmed');
    });

    $(document).click(function(event) {
        var target = $(event.target);
        if (!target.closest('.profile-description').length && !target.is('#edit-profile-description')) {
            $('#profile-description-form').hide();
            $('body').removeClass('dimmed');
            $('.profile-description').removeClass('no-dimmed');
        }
    });
});




// Validación del botón enviar en chat
// document.getElementById('message-input').addEventListener('input', function() {
//         var sendButton = document.getElementById('send-button');
//         if (this.value.trim() === '') {
//             sendButton.disabled = true;
//         } else {
//             sendButton.disabled = false;
//         }
//     });


import Pusher from 'pusher-js';

// Suscribirse al canal de Pusher
var pusher = new Pusher(window.PUSHER_APP_KEY, {
    cluster: window.PUSHER_APP_CLUSTER,
    encrypted: true
});

var channel = pusher.subscribe('chat-channel');

// Función para desplazar el contenedor hacia abajo
function scrollToBottom() {
    var messageCard = document.getElementById('message-card');
    if (messageCard) {
        messageCard.scrollTop = messageCard.scrollHeight;
    }
}

// Escuchar eventos de Pusher
channel.bind('new-message', function(data) {
    // Actualizar la interfaz de usuario con el nuevo mensaje recibido
    var messageContainer = document.getElementById('message-container');
    if (messageContainer) {
        var newMessage = document.createElement('p');
        newMessage.classList.add('mensaje-chat');
        newMessage.innerHTML = '<strong>' + data.sender_name + ':</strong> ' + data.content;
        messageContainer.appendChild(newMessage);

        // Desplazarse automáticamente hacia abajo del contenedor de mensajes
        scrollToBottom();
    }

    // Actualizar la visualización del mensaje pendiente específico para este usuario
    var unreadMessage = document.getElementById('unread-message-' + data.sender_id);
    if (unreadMessage) {
        unreadMessage.style.display = 'block';
    }
});

// Desplazarse hacia abajo al cargar la página
window.onload = function() {
    scrollToBottom();
};

// Escuchar el envío del formulario de mensaje
document.getElementById('message-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    // Obtener los datos del formulario
    var formData = new FormData(this);

    // Realizar una solicitud AJAX al servidor
    fetch(this.action, {
        method: this.method,
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Limpiar el campo de entrada del mensaje
        document.getElementById('message-input').value = '';

        // Desplazarse automáticamente hacia abajo del contenedor de mensajes
        scrollToBottom();
    })
    .catch(error => {
        console.error('Error al enviar el mensaje:', error);
        document.getElementById('message-input').value = '';
    });
});



$(document).ready(function() {
    // Función para actualizar el read_at cada 2 segundos
    function updateReadAt() {
        $.ajax({
            url: '/messages/update-read-at', // Ruta para actualizar read_at
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Obtener el token CSRF
            },
            success: function(response) {
                console.log('read_at actualizado');
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar read_at:', error);
            }
        });
    }

    // Llamar a la función inicialmente al cargar la página
    updateReadAt();

    // Configurar la actualización periódica cada 2 segundos
    setInterval(updateReadAt, 2000);
});








// // Escuchar el envío del formulario de mensaje
// document.getElementById('message-form').addEventListener('submit', function(event) {
//     event.preventDefault(); // Evitar el envío del formulario por defecto

//     // Obtener los datos del formulario
//     var formData = new FormData(this);

//     // Realizar una solicitud AJAX al servidor
//     fetch(this.action, {
//         method: this.method,
//         body: formData
//     })
//     .then(response => response.json())
//     .then(data => {
//         // Actualizar la interfaz de usuario con el nuevo mensaje recibido
//         var messageContainer = document.getElementById('message-card');
//         if (messageContainer) {
//             var newMessage = document.createElement('p');
//             newMessage.classList.add('text-start'); // Add text-end class
//             // Verificar si data.sender está definido y si tiene una propiedad name
//             if (data.sender && data.sender.name) {
//                 newMessage.innerHTML = '<strong>' + data.sender.name + ':</strong> ' + data.content;
//                 messageContainer.appendChild(newMessage);
//             } else {
//                 // Si no se puede obtener el nombre del remitente, simplemente mostrar el contenido del mensaje
//                 newMessage.textContent = data.content;
//             }
//         }

//         // Limpiar el campo de entrada del mensaje
//         document.getElementById('message-input').value = '';
//     })
//     .catch(error => {
//         console.error('Error al enviar el mensaje:', error);
//         document.getElementById('message-input').value = '';
//     });
// });
