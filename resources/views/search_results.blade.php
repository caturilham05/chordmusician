@extends('layout.index')

@section('content')
<div class="search-input search-input-custom">
    <form id="search" action="{{route('playlist_search')}}" method="GET">
        <input class="search-custom" type="text" placeholder="@if ($search ?? '') {{$search ?? ''}} @else Search Song @endif" id='searchText' name="query" @if ($search ?? '') value="{{$search ?? ''}}" @endif onkeypress="handle" />
        <i class="fa fa-search fa-search-custom"></i>
    </form>
</div>

<div class="heading-section heading-section-custom">
    <h4>Hasil pencarian untuk: <em>{{ $query }}</em></h4>
</div>
@if ($playlists->count() > 0)
    @foreach ($playlists as  $playlist)
        <div class="item item-custom">
            <ul>
                <li><h4>{{$playlist->band}}</h4></li>
                <li><a href="{{route('chord', [
                    'year' => $playlist->published_at->format('Y'),
                    'month' => $playlist->published_at->format('m'),
                    'slug' => $playlist->slug
                ])}}">{{$playlist->title}}</a></li>
                <li class="published_date"><span>{{$playlist->publishedFormattedDate}}</span></li>
            </ul>
            <hr class="hr-custom" />
        </div>
    @endforeach
@else
    <p class="mt-4 text-muted">Tidak ditemukan hasil untuk "<strong>{{ $query }}</strong>"</p>
@endif
<div class="mt-4 mb-4 pagination-custom">
    {{ $playlists->links() }}
</div>

<div class="main-info header-text main-info-custom">
    <div class="heading-section" style="text-align: center">
        <h4>ABOUT US</h4>
    </div>
    <p style="text-align: justify">{{$home->content}}</p>
</div>

{{-- <div class="container py-4">
    <h3>Hasil pencarian untuk: <strong>{{ $query }}</strong></h3>

    @if($playlists->count() > 0)
        <ul class="list-group my-3">
            @foreach($playlists as $playlist)
                <li class="list-group-item">
                    <a href="{{ route('chord', [
                        'year' => $playlist->published_at->format('Y'),
                        'month' => $playlist->published_at->format('m'),
                        'slug' => $playlist->slug
                    ]) }}">
                        🎸 {{ $playlist->band }} — {{ $playlist->title }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="mt-4 mb-4 pagination-custom">
            {{ $playlists->links() }}
        </div>
    @else
        <p class="mt-4 text-muted">Tidak ditemukan hasil untuk "<strong>{{ $query }}</strong>"</p>
    @endif
</div> --}}
@endsection
