<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class MessageController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function chatmatches($userId)
    {
        // Verificar si el usuario autenticado está bloqueado por el usuario actual
        $isBlocked = \App\Models\UserBlock::where('blocker_id', $userId)
                                            ->where('blocked_id', Auth::id())
                                            ->exists();

        if ($isBlocked) {
            // Si el usuario está bloqueado, redirigirlo a la página de inicio.
            return redirect('http://social-app.com.devel/');
        } else {
            // Si el usuario no está bloqueado, continuar con la lógica de chat normal.
            $receiver = User::find($userId);
            $receiverName = $receiver->name; // Obtener el nombre del usuario con el que se está chateando

            // Obtener la URL de la imagen de perfil del usuario con el que se está chateando
            $receiverProfileImage = $receiver->image;

            // Obtener la URL de la imagen de perfil del usuario actual
            $currentUser = Auth::user();
            $currentUserProfileImage = $currentUser->image;

            $user = Auth::user();
            $messages = Message::where(function ($query) use ($user, $userId) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $userId);
            })->orWhere(function ($query) use ($user, $userId) {
                $query->where('receiver_id', $user->id)
                    ->where('sender_id', $userId);
            })->get();

            // Marcar los mensajes como leídos
            $unreadMessages = Message::where('receiver_id', Auth::id())
                                    ->where('sender_id', $userId)
                                    ->whereNull('read_at')
                                    ->get();

            foreach ($unreadMessages as $message) {
                $message->read_at = now();
                $message->save();
            }

            // Pasar todas las variables necesarias a la vista
            return view('matches.chatmatches', [
                'messages' => $messages,
                'receiverId' => $userId,
                'receiverName' => $receiverName,
                'receiverProfileImage' => $receiverProfileImage,
                'currentUserProfileImage' => $currentUserProfileImage
            ]);
        }
    }

    public function updateReadAt()
    {
        // Actualizar el read_at para todos los mensajes no leídos del usuario autenticado
        Message::where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }



    public function checkUnreadMessages()
    {
        // Obtener los identificadores de los usuarios con mensajes sin leer
        $unreadMessages = Message::where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->pluck('sender_id')
            ->unique();

        // Devolver los identificadores de los usuarios con mensajes sin leer en formato JSON
        return response()->json(['unreadMessages' => $unreadMessages]);
    }




    public function sendMessage(Request $request)
    {
        // Guardar el mensaje en la base de datos...
        $message = new Message;
        $message->sender_id = Auth::id();
        $message->receiver_id = $request->receiver_id;
        $message->content = $request->content;
        $message->save();

        // Emitir un evento de Pusher
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
        ]);

        // Aquí defines los datos que quieres enviar en el evento
        $data = [
            'sender_id' => $message->sender_id,
            'sender_name' => Auth::user()->name,
            'content' => $message->content,
        ];

        // Emitir el evento a un canal específico (por ejemplo, 'chat-channel') con un nombre específico (por ejemplo, 'new-message')
        $pusher->trigger('chat-channel', 'new-message', $data);

        // Devolver una respuesta JSON con el mensaje creado
        return response()->json($message);
    }
    
    
    
    


}

