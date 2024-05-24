@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Gente</h1>
            <form action="{{ route('user.index') }}" method="GET" id="buscador">
                <input type="text" id="search" class="form-control">
                <input type="submit" value="Buscar" class="btn btn-success mt-3">
            </form>
            <hr>
            @foreach($users as $user)
                @php
                    $isBlocked = \App\Models\UserBlock::where('blocker_id', Auth::id())
                                            ->where('blocked_id', $user->id)
                                            ->exists();
                    $amIBlocked = \App\Models\UserBlock::where('blocker_id', $user->id)
                                           ->where('blocked_id', Auth::id())
                                           ->exists();
                @endphp
                @if(!$amIBlocked)
                    <div class="data-user container-main-profile">
                        <div class="container-image">
                            @if($user->image)
                                <img class="avatar-profile" src="{{ route('user.avatar',['filename'=>$user->image]) }}">
                            @endif
                        </div>
                        <div class="container-profile">
                            <h2 class="nickname">{{'@'.$user->nick}}</h2>
                            <h3>{{$user->name}}</h3>
                            <h3>{{$user->surname}}</h3>
                            <p>{{'Se unió: '. FormatTime::LongTimeFilter($user->created_at) }}</p>
                            <a href="{{ route('profile',['id'=>$user->id]) }}" class="btn btn-verperfil">Ver perfil</a>
                            @if($isBlocked)
                                <form method="POST" action="{{ route('user.unblock', ['id' => $user->id]) }}">
                                    @csrf
                                    <input type="hidden" name="blocker_id" value="{{ Auth::id() }}">
                                    <input type="hidden" name="blocked_id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-desbloquearperfil">Desbloquear perfil</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('user.block', ['id' => $user->id]) }}">
                                    @csrf
                                    <input type="hidden" name="blocker_id" value="{{ Auth::id() }}">
                                    <input type="hidden" name="blocked_id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-bloquearperfil">Bloquear perfil</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
            <!-- Paginación -->
            {{$users->links('pagination::bootstrap-4')}}
        </div>
    </div>
</div>
@endsection
