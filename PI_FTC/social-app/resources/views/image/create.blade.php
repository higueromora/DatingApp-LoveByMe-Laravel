@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>Configuración de mi publicación</h1>
            <div class="card-card2 p-1">
                <div class="card-header texto-subirimagennueva">Subir nueva imagen</div>
            </div>
        
            <div class="card-body">

                <form method="POST" action="{{ route('image.save') }} " enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="image_path" class="col-md-4 col-form-label text-md-right">Imagen</label>
                        <div class="col-md-7">
                            <input id="image_path" type="file" name="image_path" class="form-control" required>

                            @error('image_path')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="description" class="col-md-4 col-form-label text-md-right">Descripción</label>
                        <div class="col-md-7">
                            <textarea id="description" name="description" class="form-control" required>@error('description'){{ old('description') }}@enderror</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-3">
                            <input type="submit" class="btn btn-subirimagen" value="Subir Imagen">                          
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
@endsection