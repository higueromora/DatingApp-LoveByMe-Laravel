<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request){
        
        // Validación
        $validate = $this->validate($request, [
            'image_id' => ['int','required'],
            'content' => ['string','required'],
        ]);

        // Recoger datos
        $user = Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        // Asigno los valores a mi nuevo objeto a guardar
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //Guardar en la bd
        $comment->save();

        // Redirección
        return redirect()->route('image.detail',['id' => $image_id])
                        ->with(['message' => 'Has publicado tu comentario correctamente']);

    }

    public function delete($id){
        // Conseguir datos del usuario identificado
        $user = Auth::user();


        // Conseguir objetos del comentario
        $comment = Comment::Find($id);


        // Comprobar si soy el dueño del comentario o de la publicación
        if($user &&($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();

            // Redirección
            return redirect()->route('image.detail',['id' => $comment->image->id])
                            ->with(['message' => 'Comentario eliminado correctamente']);
        }else{
            // Redirección
            return redirect()->route('image.detail',['id' => $comment->image->id])
                            ->with(['message' => 'El Comentario no se ha eliminado!!']);
        }


    }

    public function deleteAdmin(Request $request, $id)
    {
        $comment = Comment::find($id);

        // Verificar si el usuario autenticado es un administrador
        if(auth()->user()->role === 'admin') {
            // Eliminar el comentario
            $comment->delete();

            // Redirigir a la página deseada
            return redirect()->route('image.detail',['id' => $comment->image->id])->with('success', 'Comentario eliminado correctamente por el usuario administrador.');
        } else {
            // Si el usuario autenticado no es un administrador, redirigir a una página de error o mostrar un mensaje de error
            return redirect()->back()->with('error', 'Solo los administradores pueden realizar esta acción.');
        }
    }


}
