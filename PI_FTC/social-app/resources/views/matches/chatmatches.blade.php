@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="">
            <div class="list-group">
                <div class="list-group">
                    <!-- Mostrar el nombre del usuario con el que se está chateando -->
                    <div class="list-group-item active">
                        Chateando con: {{ $receiverName }}
                    </div>
                    <!-- Mostrar la imagen de perfil del usuario con el que se está chateando -->
                    <div class="list-group-item chat-row">
                        @if($receiverProfileImage)
                            <img class="avatar-profile" src="{{ route('user.avatar',['filename'=>$receiverProfileImage]) }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="card" id="message-card">
                <div class="card-body" id="message-container">
                    <!-- Aquí irían los mensajes del chat -->
                    @foreach ($messages as $message)
                    <!-- <p class="mensaje-chat" class="{{ $message->sender_id == Auth::id() ? 'text-center' : 'text-center' }}"> -->
                    <p class="mensaje-chat">
                        <strong>{{ $message->sender->name }}:</strong> {{ $message->content }}
                    </p>
                    @endforeach
                </div>
                <div class="card-footer">
                    <form id="message-form" action="{{ route('messages.send') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $receiverId }}">
                        <input id="message-input" type="text" name="content" class="form-control" placeholder="Escribe un mensaje...">
                        <button type="submit" class="btn btn-primary mt-2">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        var authUserId = "{{ Auth::id() }}";
    </script>
    <script src="{{ asset('js/updateRead_at.js') }}"></script>
    
@endpush
