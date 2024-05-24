<?php

namespace App\Http\Controllers;

use App\Models\LikeMatch;
use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserMatchController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function showProfile($id)
    {
    // Obtén el usuario del perfil
    $target_user = User::find($id);

    // Comprueba si el usuario autenticado ya ha dado "like" al usuario del perfil
    $user_like = LikeMatch::where('user_id', auth()->id())
                          ->where('target_user_id', $target_user->id)
                          ->where('click_type', 'like')
                          ->exists();

    // Pasa las variables a la vista
    return view('user.profile', ['target_user_id' => $target_user->id, 'user_like' => $user_like]);
    }

    public function searchmatch($search = null)
    {
        // Obtén el usuario autenticado
        $user = auth()->user();

        // Busca los "matches" del usuario autenticado
        $matches = UserMatch::where('user1_id', $user->id)
                            ->orWhere('user2_id', $user->id)
                            ->pluck('user1_id', 'user2_id')
                            ->toArray();

        // Filtra los usuarios que coinciden con la búsqueda y que son "matches" del usuario autenticado
        $usersQuery = User::query();
        $usersQuery->where(function ($query) use ($search) {
            $query->where('nick', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->orWhere('surname', 'LIKE', '%' . $search . '%')
                ->orWhere('genero', 'LIKE', '%' . $search . '%')
                ->orWhere('residencia', 'LIKE', '%' . $search . '%') // Buscar por residencia
                ->orWhere('edad', '=', $search); // Buscar por edad exacta
        });

        if (!empty($matches)) {
            $usersQuery->whereIn('id', $matches);
        } else {
            // Si no hay "matches", asegúrate de que la consulta no devuelva ningún resultado
            $usersQuery->where('id', 0);
        }

        // Ordena los resultados y pagínalos
        $users = $usersQuery->orderBy('id', 'desc')->paginate(5);

        return view('matches.indexmatch', [
            'users' => $users,
        ]);
    }
    
    //REVISAR
    public function indexmatch($search = null)
{
    // Tu consulta SQL
    $sql = "
        INSERT INTO usermatch (user1_id, user2_id, created_at, updated_at)
        SELECT DISTINCT
            CASE 
                WHEN u1.user_id < u2.user_id THEN u1.user_id
                ELSE u2.user_id
            END,
            CASE 
                WHEN u1.user_id > u2.user_id THEN u1.user_id
                ELSE u2.user_id
            END,
            NOW(), 
            NOW()
        FROM likematch AS u1
        JOIN likematch AS u2 ON u1.user_id = u2.target_user_id AND u1.target_user_id = u2.user_id
        WHERE u1.click_type = 'like' AND u2.click_type = 'like'
        AND NOT EXISTS (
            SELECT 1 FROM usermatch
            WHERE (user1_id = LEAST(u1.user_id, u2.user_id) AND user2_id = GREATEST(u1.user_id, u2.user_id))
        );
    ";

    // Ejecuta la consulta SQL
    DB::statement($sql);
    

    // Obtén el usuario actualmente autenticado
    $user = auth()->user();

    // Busca los "matches" del usuario autenticado
    $matches = UserMatch::where(function ($query) use ($user) {
        $query->where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id);
    })
    ->where(function ($query) use ($user) {
        $query->where('user1_id', '<>', $user->id)
            ->orWhere('user2_id', '<>', $user->id);
    })
    ->get();

    // Obtén los usuarios que han hecho "match" con el usuario autenticado y coinciden con la búsqueda
    $users = User::query()
        ->whereIn('id', $matches->pluck('user1_id')->merge($matches->pluck('user2_id')))
        ->where(function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('surname', 'LIKE', '%' . $search . '%')
                  ->orWhere('genero', 'LIKE', '%' . $search . '%')
                  ->orWhere('residencia', 'LIKE', '%' . $search . '%')
                  ->orWhere('edad', '=', $search);
        })
        ->paginate(5);

    return view('matches.indexmatch', [
        'users' => $users
    ]);
}   




}
