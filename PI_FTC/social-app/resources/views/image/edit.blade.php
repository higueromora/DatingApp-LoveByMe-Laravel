@extends('layouts.app')

@section('content')
    <h1>Configuración de mi publicación</h1>

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Editar mi imagen</div>
            </div>
        
            <div class="card-body">

                <form method="POST" action="{{route('image.update')}}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="image_id" value="{{$image->id}}">

                    <div class="form-group row">
                        <label for="image_path" class="col-md-4 col-form-label text-md-right">Imagen</label>
                        <div class="col-md-7">
                        @if($image->user->image)
                            <img class="avatar" src="{{ route('image.file',['filename' => $image->image_path]) }}" alt="">
                         @endif
                            <input id="image_path" type="file" name="image_path" class="form-control mt-2">

                            @error('image_path')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-4">
                        <label for="description" class="col-md-4 col-form-label text-md-right">Descripción</label>
                        <div class="col-md-7">
                            <textarea id="description" name="description" class="form-control" required>@error('description'){{ old('description') }}@enderror {{$image->description}}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-3">
                            <input type="submit" class="btn btn-primary mt-3" value="Actualizar Imagen">                          
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
@endsection