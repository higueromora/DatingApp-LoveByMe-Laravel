@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Matches</h1>
            <form action="{{ route('user.match.index') }}" method="GET" id="buscadormatch">
                <input type="text" id="search" class="form-control">
                <input type="submit" value="Buscar" class="btn btn-success mt-3">
            </form>
            <hr>
            @foreach($users as $user)
    @if($user->id !== auth()->id()) {{-- Verifica si el usuario no es el usuario autenticado --}}
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
                    <!-- Mostrar "Mensajes pendientes" si hay mensajes sin leer -->
                    @php
                    // Verificar si hay mensajes sin leer entre el usuario autenticado y el usuario actual
                    $unreadMessages = \App\Models\Message::where('sender_id', $user->id)
                        ->where('receiver_id', Auth::id())
                        ->whereNull('read_at')
                        ->exists();
                    @endphp
                    @if ($unreadMessages === true)
                        <p id="unread-message-{{ $user->id }}" style="display: block;">Mensaje pendiente</p>
                    @else
                        <p id="unread-message-{{ $user->id }}" style="display: none;">Mensaje pendiente</p>
                    @endif


                    <h3>{{$user->name.' '.$user->surname}}</h3>
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
                        <a href="{{ route('chat.matches', ['userId' => $user->id]) }}" class="btn btn-chatcon">Chat con {{ $user->name }}</a>
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
    @endif
@endforeach
            <!-- Paginación -->

        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script src="{{ asset('js/updateRead_at.js') }}"></script>
@endpush