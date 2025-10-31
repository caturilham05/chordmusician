@extends('layout.index')

@section('content')
<div class="main-banner">
    <div class="row">
      <div class="col-lg-7">
        <div class="header-text">
            {!!$home->title!!}
            {!!$home->intro!!}
            <div class="main-button">
                <a href="{{route('playlist')}}">Browse Playlists Now</a>
              </div>
        </div>
      </div>
    </div>
</div>

<div class="main-profile mt-5 mb-3">
    <div class="row">
        <div class="col-lg-4">
            <div class="heading-section" style="text-align: center">
                <h4>NEW PLAYLIST</h4>
            </div>
            <ul>
                @foreach ($playlists as $playlist)
                    <li><a href="{{route('chord', [
                        'year' => $playlist->published_at->format('Y'),
                        'month' => $playlist->published_at->format('m'),
                        'slug' => $playlist->slug
                    ])}}">{{$playlist->band}} - {{$playlist->title}}</a></li>
                @endforeach
            </ul>
            <div class="heading-section" style="text-align: center">
                <h4 style="margin-top: 30px">MOST VISITED SONGS</h4>
            </div>
            <ul>
                @foreach ($playlists_click as $click)
                    <li><a href="{{route('chord', [
                        'year' => $click->published_at->format('Y'),
                        'month' => $click->published_at->format('m'),
                        'slug' => $click->slug
                    ])}}">{{$click->band}} - {{$click->title}} ({{$click->click}})</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-lg-8">
            <div class="main-info header-text">
                <div class="heading-section" style="text-align: center">
                    <h4>ABOUT US</h4>
                </div>
                <p style="text-align: justify">{{$home->content}}</p>
            </div>
        </div>
    </div>
</div>
@endsection
