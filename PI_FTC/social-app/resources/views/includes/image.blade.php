@php
    $isBlocked = \App\Models\UserBlock::where('blocker_id', Auth::id())
                                    ->where('blocked_id', $image->user->id)
                                    ->exists();
    $amIBlocked = \App\Models\UserBlock::where('blocker_id', $image->user->id)
                                   ->where('blocked_id', Auth::id())
                                   ->exists();
@endphp
@if(!$amIBlocked)
<div class="card-card">
    <div class="card-header">
        <div class="data-user">
            @if($image->user->image)
            <img class="avatar" src="{{ route('user.avatar',['filename'=>$image->user->image]) }}">
            @endif
            <a href="{{ route('profile',['id'=> $image->user->id]) }}">
                {{ $image->user->name}}
                <span class="nickname">
                    {{ ' | @'.$image->user->nick}}
                </span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="container_image_under">
            <img class="image_under_card" src="{{ route('image.file',['filename' => $image->image_path]) }}" alt="">
        </div>
        <div class="description">

            <span class="nickname">{{ '@'. $image->user->nick}} | {{ FormatTime::LongTimeFilter($image->created_at) }}</span>
            <p>{{$image->description}}</p>
        </div>
        <div class="d-flex align-items-center">
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
            <a href="{{ route('image.detail',['id'=> $image->id]) }}" class="btn btn-comments">
                Comentarios {{count($image->comments)}}
            </a>
        </div>

        <!-- @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }} -->
    </div>
</div>
@endif