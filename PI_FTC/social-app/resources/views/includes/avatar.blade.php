<!-- Otra forma de hacer lo mismo dento del if -->
<!-- <img src="{{ url('/user/avatar/'.Auth::user()->image) }}"> -->
@if(Auth::user()->image)
     <img class="avatar" src="{{ route('user.avatar',['filename'=>Auth::user()->image]) }}">
@endif