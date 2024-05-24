@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.message')
            <div class="card-card">
                <div class="card-header">
                    @if($image->user->image)
                    <img class="avatar" src="{{ route('user.avatar',['filename'=>$image->user->image]) }}">
                    @endif
                    <!-- <img class="avatar" src="{{ route('user.avatar',['filename'=>Auth::user()->image]) }}"> -->
                    {{ $image->user->name.' '.$image->user->surname }}
                    <span class="nickname">
                        {{ ' | @'.$image->user->nick}}
                    </span>
                </div>
                <div class="card-body">
                    <div class="container_image_under">
                        <img class="image_under_card" src="{{ route('image.file',['filename' => $image->image_path]) }}" alt="">
                    </div>
                    <div class="description">
                        <span class="nickname">{{ '@'. $image->user->nick}} | {{ FormatTime::LongTimeFilter($image->created_at) }}</span>
                        <p>{{$image->description}}</p>
                    </div>
                    <div class="d-flex justify-content-evenly">
                        <div class="likes">

                            <!-- Comprobar si el usuario le dio Like a la imagen -->
                            <?php $user_like = false; ?>
                            @foreach($image->likes as $like)
                            @if($like->user->id == Auth::user()->id)
                            <?php $user_like = true; ?>
                            @endif
                            @endforeach

                            <!-- @if($user_like)
                                <img class="btn-dislike" src="{{ asset('img/like.svg') }}">
                                @else
                                <img class="btn-like" src="{{ asset('img/like2.svg') }}">
                                @endif                            -->

                            @if($user_like)
                            <img class="btn-dislike" data-id="{{$image->id}}" src="{{ asset('img/like.svg') }}">
                            @else
                            <img class="btn-like" data-id="{{$image->id}}" src="{{ asset('img/like2.svg') }}">
                            @endif
                            <span class="number_likes">{{count($image->likes)}} </span>
                        </div>
                        @if(Auth::user() && Auth::user()->role === 'admin')
                        <div class="actions">
                            <!-- Otros botones de acciones -->

                            <!-- Botón de eliminación de imagen para el usuario administrador -->
                            <form method="POST" action="{{ route('image.delete.admin', ['id' => $image->id]) }}" onsubmit="return confirm('¿Estás seguro de que quieres borrar esta imagen como administrador? Esta acción no se puede deshacer.')">
                                @csrf
                                <button type="submit" class="btn btn-danger">Eliminar Imagen (Admin)</button>
                            </form>
                        </div>
                        @endif
                        @if(Auth::user() && Auth::user()->id == $image->user->id)
                        <div class="actions">
                            <a href="{{route('image.edit',['id' => $image->id])}}" class="btn  btn-actualizarcomentario">Actualizar</a>
                            <!-- <a href="{{route('image.delete',['id' => $image->id])}}" class="btn btn-sm btn-danger">Borrar</a> -->

                            <!-- MODAL -->
                            <!-- Trigger the modal with a button -->
                            <button type="button" class="btn btn-bloquearperfil" data-toggle="modal" data-target="#myModal">Eliminar</button>
                            <!-- Modal -->
                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">¿Estás seguro?</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Si eliminas esta imagen nunca podrás recuperarla</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                                            <a href="{{route('image.delete',['id' => $image->id])}}" class="btn btn-danger">Borrar Defintivamente</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- MODAL -->

                        </div>
                    </div>
                    @endif

                    <div class="comments">
                        <h2>Comentarios {{count($image->comments)}}</h2>
                    </div>

                </div>

                <form method="POST" action="{{route('comment.save')}}">
                    @csrf

                    <input type="hidden" name="image_id" value="{{$image->id}}">
                    <p>
                        <textarea class="form-control" name="content" required></textarea>
                        @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </p>
                    <button type="submit" class="btn btn-success" style="margin-left: 5px;">Enviar</button>
                </form>
                <hr>
                @foreach ($image->comments as $comment)
                <div class="comment">
                    <span class="nickname">{{ '@'. $comment->user->nick}} | {{ FormatTime::LongTimeFilter($image->created_at) }}</span>
                    <p>{{$comment->content}}</p>
                    @if(Auth::check() &&($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                    <a href="{{route('comment.delete',['id' => $comment->id])}}" class="btn btn-sm btn-bloquearperfil">
                        Eliminar
                    </a>
                    @endif
                    @if(Auth::user() && Auth::user()->role === 'admin')
                        <!-- Botón de eliminación de comentario para el usuario administrador -->
                        <form method="POST" action="{{ route('comment.delete.admin', ['id' => $comment->id]) }}" onsubmit="return confirm('¿Estás seguro de que quieres borrar este comentario como administrador? Esta acción no se puede deshacer.')">
                            @csrf
                            <button type="submit" class="btn btn-danger">Eliminar Comentario (Admin)</button>
                        </form>
                    @endif
                </div>
                @endforeach
                
                <!-- @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }} -->
            </div>
        </div>
    </div>



</div>
</div>
@endsection