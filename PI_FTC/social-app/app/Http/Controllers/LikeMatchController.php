<?php

namespace App\Http\Controllers;

use App\Models\LikeMatch;
use App\Models\UserMatch;
use Illuminate\Http\Request;

class LikeMatchController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function likematch($id)
    {
    // Obtén el usuario actualmente autenticado
    $user = auth()->user();

    // Busca un "like" existente o crea uno nuevo
    $like = LikeMatch::firstOrNew([
        'user_id' => $user->id,
        'target_user_id' => $id
    ]);

    // Actualiza el tipo de clic y guarda el "like"
    $like->click_type = 'like';
    $like->save();

    
    }

    public function dislikematch($id)
    {
        // Obtén el usuario actualmente autenticado
        $user = auth()->user();

        // Busca un "like" existente
        $like = LikeMatch::where('user_id', $user->id)
                        ->where('target_user_id', $id)
                        ->where('click_type', 'like')
                        ->first();

        if ($like) {
            // Si existe un "like", elimínalo
            $like->delete();

            // Elimina cualquier registro de usermatch relacionado
            UserMatch::where(function ($query) use ($user, $id) {
                $query->where('user1_id', $user->id)
                    ->where('user2_id', $id);
            })->orWhere(function ($query) use ($user, $id) {
                $query->where('user1_id', $id)
                    ->where('user2_id', $user->id);
            })->delete();
        }

        return response()->json(['disliked' => true]);
    }




    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
