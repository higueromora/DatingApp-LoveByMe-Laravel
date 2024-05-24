@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Bloqueados</h1>
            <!-- <form action="{{ route('user.index') }}" method="GET" id="buscador">
                <input type="text" id="search" class="form-control">
                <input type="submit" value="Buscar" class="btn btn-success">
            </form> -->
            <hr>
            @foreach($users as $userBlock)
                    @php
                        $user = $userBlock->blocked;
                    @endphp
                    <div class="data-user container-main-profile">
                        <div class="container-image">
                            @if($user->image)
                                <img class="avatar-profile" src="{{ route('user.avatar',['filename'=>$user->image]) }}">
                            @endif
                        </div>
                        <div class="container-profile">
                            <h2>{{'@'.$user->nick}}</h2>
                            <h3>{{$user->name.' '.$user->surname}}</h3>
                            <p>{{'Se unió: '. FormatTime::LongTimeFilter($user->created_at) }}</p>
                            <a href="{{ route('profile',['id'=>$user->id]) }}" class="btn btn-verperfil">Ver perfil</a>
                                <form method="POST" action="{{ route('user.unblock', ['id' => $user->id]) }}">
                                    @csrf
                                    <input type="hidden" name="blocker_id" value="{{ Auth::id() }}">
                                    <input type="hidden" name="blocked_id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-desbloquearperfil">Desbloquear perfil</button>
                                </form>
                        </div>
                    </div>
            @endforeach
            <!-- Paginación -->
            {{$users->links('pagination::bootstrap-4')}}
        </div>
    </div>
</div>
@endsection
