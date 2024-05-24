<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\LikeMatch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    // para que me lleve a la pantalla de login si no estamos autenticado y queremos entrar en otra url
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index($search = null)
    {
        if (!empty($search)) {
            $users = User::where('nick', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->orWhere('surname', 'LIKE', '%' . $search . '%')
                ->orWhere('genero', 'LIKE', '%' . $search . '%')
                ->orWhere('residencia', 'LIKE', '%' . $search . '%') // Buscar por residencia
                ->orWhere('edad', '=', $search) // Buscar por edad exacta
                ->orWhere(User::raw("CONCAT(name, ' ', surname)"), 'LIKE', '%' . $search . '%')
                ->orderBy('id', 'desc')
                ->paginate(5);
        } else {
            $users = User::orderBy('id', 'desc')->paginate(5);
        }

        return view('user.index', [
            'users' => $users,
        ]);
    }


    public function delete(Request $request)
    {
        $user = Auth::user();
    
        // Elimina los registros relacionados en likematch
        $user->likeMatches()->delete();
    
        // Elimina los registros relacionados en usermatch
        $user->userMatches()->delete();
        $user->matchesAsUser1()->delete();
        $user->matchesAsUser2()->delete();
    
        // Elimina los registros relacionados en messages
        $user->sentMessages()->delete();
        $user->receivedMessages()->delete();
    
        // Elimina los registros relacionados en user_blocks
        $user->blockedUsers()->delete();
        $user->blockingUsers()->delete();
    
        // Elimina los registros relacionados en images
        foreach ($user->images as $image) {
            // Elimina los comentarios asociados a cada imagen
            $image->comments()->delete();
    
            // Elimina los likes asociados a cada imagen
            $image->likes()->delete();
    
            // Elimina la imagen del almacenamiento
            Storage::disk('public')->delete($image->image_path);
    
            // Elimina el registro de la imagen
            $image->delete();
        }
    
        // Elimina los comentarios hechos por el usuario en imágenes de otros usuarios
        Comment::where('user_id', $user->id)->delete();
    
        // Elimina los likes hechos por el usuario en imágenes de otros usuarios
        Like::where('user_id', $user->id)->delete();
    
        // Elimina los registros en likematch donde el usuario es el objetivo
        LikeMatch::where('target_user_id', $user->id)->delete();
    
        // Elimina el perfil completo (incluyendo relaciones)
        $user->delete();
    
        // Redirige al usuario a la URL deseada
        return redirect('http://social-app.com.devel/login')->with('success', 'Perfil eliminado correctamente.');
    }
    
    public function deleteProfile(Request $request, $id)
    {
        // Obtener el usuario que se va a eliminar
        $user = User::find($id);

        // Verificar si el usuario autenticado tiene permisos de administrador
        if(auth()->user()->role === 'admin') {
            // Eliminar los registros relacionados con el usuario
            $user->likeMatches()->delete();
            $user->userMatches()->delete();
            $user->matchesAsUser1()->delete();
            $user->matchesAsUser2()->delete();
            $user->sentMessages()->delete();
            $user->receivedMessages()->delete();
            $user->blockedUsers()->delete();
            $user->blockingUsers()->delete();

            foreach ($user->images as $image) {
                $image->comments()->delete();
                $image->likes()->delete();
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            Comment::where('user_id', $user->id)->delete();
            Like::where('user_id', $user->id)->delete();
            LikeMatch::where('target_user_id', $user->id)->delete();

            // Eliminar el perfil del usuario
            $user->delete();

            // Redirigir a la página deseada
            return redirect('http://social-app.com.devel/')->with('success', 'Perfil eliminado correctamente.');
        } else {
            // Si el usuario autenticado no es administrador, redirigir a una página de error o mostrar un mensaje de error
            return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
        }
    }


    public function updateProfileDescription(Request $request, $id)
    {
        $user = User::find($id);
        
        // Verificar si el usuario autenticado es el propietario del perfil
        if(Auth::user()->id === $user->id) {
            // Validar la solicitud
            $request->validate([
                'profileDescription' => ['required', 'string', 'max:255'],
            ]);
            
            // Actualizar la descripción del perfil
            $user->profileDescription = $request->input('profileDescription');
            $user->save();
            
            return redirect()->back()->with('success', 'Descripción del perfil actualizada correctamente.');
        } else {
            // Si el usuario autenticado no es el propietario del perfil, redirigir o mostrar un mensaje de error
            return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
        }
    }

    public function config(){
        return view('user.config');
    }

    public function update(Request $request){
        //Usuario identificado
        $user = Auth::user();
        $id = $user->id;

        //validación del formulario, cogemos datos de documentacion de laravel o de las verificaciones
        // propias que nos proporciona en otro archivo laravel (RegisterController)
        $validate = $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255','unique:users,nick,'.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
        ]);

        
       
        //Conseguir datos de los input del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        // Subir la imagen
        $image_path = $request->file('image_path');
        if($image_path){
            // Poner nombre único
            $image_path_name= time().$image_path->getClientOriginalName();

            // Guardar en la carpeta storage (storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            // Seteo el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }
        
        //debugeando
        // var_dump($id);
        // var_dump($name);
        // var_dump($surname);
        // var_dump($nick);
        // var_dump($email);
        // die();

        //Asingar nuevos valores al objeto usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //Ejecutar consulta un cambio en la base de datos muestra error en vcode pero funciona bien
        // en la aplicación sin errores y corrrectamente
        $user->update();

        return redirect()->route('config')
                        ->with(['message' => 'Usuario actualizado correctamente']);
    }

    public function updatePassword(Request $request){
        //Usuario identificado
        $user = Auth::user();
        $id = $user->id;

        //validación del formulario, cogemos datos de documentacion de laravel o de las verificaciones
        // propias que nos proporciona en otro archivo laravel (RegisterController)
        $validate = $this->validate($request,[
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);



        //Ejecutar consulta un cambio en la base de datos muestra error en vcode pero funciona bien
        // en la aplicación sin errores y corrrectamente
        $user->update();

        return redirect()->route('config')
                        ->with(['message' => 'Contraseña actualizada correctamente']);
    }

    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }

    // public function profile($id){
    //     $user = User::find($id);

    //     return view('user.profile', [
    //         'user' => $user
    //     ]);
    // }



    public function profile($id)
    {
        // Obtén el usuario del perfil
        $user = User::find($id);

        // Comprueba si el usuario autenticado ya ha dado "like" al usuario del perfil
        $user_like = LikeMatch::where('user_id', auth()->id())
                            ->where('target_user_id', $user->id)
                            ->where('click_type', 'like')
                            ->exists();

        // Pasa las variables a la vista
        return view('user.profile', [
            'user' => $user,
            'user_like' => $user_like,
            'target_user_id' => $user->id  // Asegúrate de que estás pasando esta variable a tu vista
        ]);
    }





    

}
