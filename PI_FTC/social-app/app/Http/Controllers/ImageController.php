<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    // para que me lleve a la pantalla de login si no estamos autenticado y queremos entrar en otra url
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }

    public function save(Request $request){

        // Validación
        $validate = $this->validate($request, [
            'description' => ['required'],
            'image_path' => ['required','image'],
        ]);

        // Recoger datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        // Asignar valores nuevo
        $user = Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;

        //Subir fichero
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save();

        return redirect()->route('home')
                        ->with(['message' => 'La foto ha sido subida correctamente']);

    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);

    }

    public function detail($id){
        $image = Image::Find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }

    public function delete($id){
        $user = Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if($user && $image && $image->user->id == $user->id){
            
            //Eliminar comentarios
            if($comments && count($comments) >=1){
                foreach($comments as $comments){
                    $comments->delete();
                }
            }

            //Eliminar los likes
            if($likes && count($likes) >=1){
                foreach($likes as $likes){
                    $likes->delete();
                }
            }

            //Eliminar ficheros de imagen
            Storage::disk('images')->delete($image->image_path);


            //Eliminar registro de la imagen
            $image->delete();

            $message = array('message' => 'La imagen se ha borrado correctamente');
        }else{
            $message = array('message' => 'La imagen no se ha borrado');
        }

        return redirect()->route('home')
                        ->with($message);

    }

    public function deleteAdmin(Request $request, $id)
    {
        $image = Image::find($id);

        // Verificar si el usuario autenticado es un administrador
        if(auth()->user()->role === 'admin') {
            // Eliminar los comentarios asociados a la imagen
            $image->comments()->delete();

            // Eliminar los likes asociados a la imagen
            $image->likes()->delete();

            // Eliminar la imagen del almacenamiento
            Storage::disk('images')->delete($image->image_path);

            // Eliminar la imagen de la base de datos
            $image->delete();

            // Redirigir a la página deseada
            return redirect()->route('home')->with('success', 'Imagen eliminada correctamente por el usuario administrador.');
        } else {
            // Si el usuario autenticado no es un administrador, redirigir a una página de error o mostrar un mensaje de error
            return redirect()->back()->with('error', 'Solo los administradores pueden realizar esta acción.');
        }
    }
    

    public function edit($id){
        $user = Auth::user();
        $image = Image::find($id);

        if($user && $image && $image->user->id == $user->id){
            return view('image.edit', [
                'image' => $image
            ]);
        }else{
            return redirect()->route('home');
        }
    }

    public function update(Request $request){
        // Validación
        $validate = $this->validate($request, [
            'description' => ['required'],
            'image_path' => ['image'],
        ]);

        // Recoger los datos
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //Conseguir objeto image
        $image = Image::find($image_id);
        $image->description = $description;

        //Subir fichero
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        //Actualizar registro
        $image->update();

        return redirect()->route('image.detail',['id' => $image_id])
                        ->with(['message' => 'Imagen actualizada con éxito']);

    }

}
