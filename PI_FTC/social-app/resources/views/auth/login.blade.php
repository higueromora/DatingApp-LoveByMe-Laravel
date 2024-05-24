@extends('layouts.app')

@section('content')
<div class="container-login">
  <div class="cardd">
    <img class="pareja-feliz" src="{{ asset('img/pareja-feliz.jpg') }}" alt="Pareja feliz">
    <p class="headingg">Encuentra a la persona perfecta</p>
    <p>LoveByMe</p>
  </div>
</div>


<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?: Cookie::get('remembered_username') }}" required autocomplete="email" autofocus>


                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Constraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') ?: Cookie::get('remembered_password') }}" required autocomplete="current-password">


                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input type="checkbox" name="remember_credentials" id="remember_credentials" {{ old('remember_credentials') ? 'checked' : '' }} {{ Cookie::get('remember_credentials_checked') ? 'checked' : '' }}>
                                    <label for="remember_credentials">{{ __('Recordar usuario y contraseña') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-acceder">
                                    {{ __('Acceder') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-recordar" href="{{ route('password.request') }}">
                                        {{ __('¿Has olvidado la contraseña?') }}
                                    </a>
                                @endif
                            </div>
                        </div> -->

                        <div class="container-botones-login">
                            <div class="botones-login">
                                <button type="submit" class="btn btn-acceder">
                                    {{ __('Acceder') }}
                                </button>
    
                                @if (Route::has('password.request'))
                                    <a class="btn btn-recordar" href="{{ route('password.request') }}">
                                        {{ __('¿Has olvidado la contraseña?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
               

@endsection
