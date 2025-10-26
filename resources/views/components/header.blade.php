<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="/" class="logo">
                        {{-- <h3 style="color: #fff !important">Chord Musisi</h3> --}}
                        <img src="{{asset('assets/images/header.png')}}" alt="">
                    </a>

                    <div class="search-input">
                        <form id="search" action="{{route('playlist_search')}}" method="GET">
                            <input type="text" placeholder="@if ($search ?? '') {{$search ?? ''}} @else Search Song @endif" id='searchText' name="query" @if ($search ?? '') value="{{$search ?? ''}}" @endif onkeypress="handle" />
                            <i class="fa fa-search"></i>
                        </form>
                    </div>
                    <!-- ***** Search End ***** -->

                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        {{-- <li><a href="/" class="active">Home</a></li> --}}
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li><a href="{{route('playlist')}}">Playlist</a></li>
                        <li><a href="{{route('request_chord')}}">Request Chord</a></li>
                        <li style="display: none"><a href="{{route('home')}}">Profile <img src="{{asset('assets/images/profile-header.jpg')}}" alt=""></a></li>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
