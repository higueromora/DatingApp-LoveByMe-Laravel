@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="data-user container-main-profile">
                <div class="container-image">
                    @if($user->image)
                    <img class="avatar-profile" src="{{ route('user.avatar',['filename'=>$user->image]) }}">
                    @endif
                </div>
                <div class="container-profile">
                    <h1>{{'@'.$user->nick}}</h1>
                    <p>{{$user->name.' '.$user->surname}}</p>
                    <p>{{'Se unió: '. FormatTime::LongTimeFilter($user->created_at) }}</p>
                    <div class="likes">
                    <!-- Mostrar el texto "ADMIN" solo si el usuario actual tiene el rol de administrador -->
                        @if($user->role === 'admin')
                            <p>⭐ADMIN</p>
                        @endif

                        <!-- Mostrar el botón de borrar perfil solo si el usuario actual es administrador y es diferente al usuario que se está mostrando en pantalla -->
                        @if(auth()->user()->role === 'admin' && auth()->user()->id !== $user->id)
                            @if(auth()->user()->role === 'admin')
                            <form method="POST" action="{{ route('user.deleteProfile', ['id' => $user->id]) }}" onsubmit="return confirm('¿Estás seguro de que quieres borrar este perfil? Esta acción no se puede deshacer.')">
                                @csrf
                                <button type="submit" class="btn btn-danger">Borrar Perfil</button>
                            </form>
                            @endif
                        @endif

                        @php
                        // Obtén el ID del usuario autenticado
                        $user_id = auth()->id();

                        // Comprueba si el usuario autenticado ya ha dado "like" al usuario del perfil
                        $user_likematch = \App\Models\LikeMatch::where('user_id', $user_id)
                        ->where('target_user_id', $target_user_id)
                        ->where('click_type', 'like')
                        ->exists();
                        @endphp

                        @if($user_likematch)
                        <!-- Si el usuario autenticado ya ha dado "like" al usuario del perfil, muestra el botón "dislike" -->
                        <img class="btn-dislikematch" data-id="{{ $target_user_id }}" src="{{ asset('img/LikeMatch.svg') }}">
                        @else
                        <!-- Si el usuario autenticado no ha dado "like" al usuario del perfil, muestra el botón "like" -->
                        <img class="btn-likematch" data-id="{{ $target_user_id }}" src="{{ asset('img/like2.svg') }}">
                        @endif
                        

                    </div>
                    <div class="profile-description">
                        <div class="contain-aboutme">
                            <h1>Sobre mí</h1>
                            <h2 class="h2-descripcion">{{ $user->profileDescription }}</h2>
                        </div>
                        @if(Auth::user()->id === $user->id)
                            <p id="edit-profile-description" class="btn btn-editprofile" style="cursor: pointer;">Editar Sobre mí</p>
                        @endif
                            <form id="profile-description-form" class="form-description" method="POST" action="{{ route('user.updateProfileDescription', ['id' => $user->id]) }}">
                                @csrf
                                <div class="editar-perfil">
                                    <textarea id="profile-description-input" name="profileDescription" rows="4" cols="25">{{ $user->profileDescription }}</textarea>
                                    <button type="submit" class="btn btn-savedescription">Guardar descripción</button>
                                </div>
                            </form>
                    </div>

                    <!-- Podríamos añadir una nueva columna con una descripción del perfil -->
                </div>
            </div>


            @foreach($user->images as $image)
            @include('includes.image', ['image'=>$image])
            @endforeach
            <!-- Paginación -->

        </div>



    </div>
</div>
@endsection