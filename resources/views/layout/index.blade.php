<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    {{-- <meta name="google-site-verification" content="C4lx1dlw8HZqvEsx72FmMuCkFiQ5gnM0PZHay9n7m3s" /> --}}
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    {{-- <meta name="description" content="{{ $description ?? 'Temukan chord gitar lagu-lagu Indonesia dan Barat di Chord Musician.' }}"> --}}
    <meta name="keywords" content="{{ $keywords ?? 'chord, kunci gitar, lirik lagu, chord musisi, chord gitar indonesia, chord musician, kumpulan chord, lagu populer, chord lagu barat, chord lagu indonesia' }}">
    {{-- <meta name="robots" content="index, follow"> --}}

    @section('seo')
        {!! seo($SEOData?? null) !!}
    @show

    {{-- ====== Tambahan META Khusus Jika Halaman Punya Video ====== --}}
    @isset($youtubeId)
        {{-- OpenGraph video --}}
        <meta property="og:video" content="https://www.youtube.com/watch?v={{ $youtubeId }}">
        <meta property="og:video:type" content="text/html">
        <meta property="og:video:width" content="1280">
        <meta property="og:video:height" content="720">
        <meta property="og:image" content="https://img.youtube.com/vi/{{ $youtubeId }}/hqdefault.jpg">

        {{-- Twitter Player Card --}}
        <meta name="twitter:card" content="player">
        <meta name="twitter:player" content="https://www.youtube.com/watch?v={{ $youtubeId }}">
        <meta name="twitter:player:width" content="1280">
        <meta name="twitter:player:height" content="720">
    @else
        {{-- Default (tanpa video) --}}
        <meta property="og:image" content="{{ secure_url('favicon.png') }}">
        <meta name="twitter:card" content="summary">
    @endisset

    {{-- <title>{{str_replace('-', ' ', config('app.name'))}} | {{$title ?? 'Chord Musisi - Kumpulan Chord Lagu Terlengkap'}}</title> --}}
    {{-- <title>{{str_replace('-', ' ', config('app.name'))}}</title> --}}

    {{-- <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"> --}}
    {{-- <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}"> --}}
    {{-- <link rel="icon" type="image/png" href="/favicon.ico"> --}}
    {{-- <link rel="icon" type="image/x-icon" href="/favicon.ico"> --}}
    {{-- <link rel="shortcut icon" href="/favicon.ico"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">


    <!-- Bootstrap core CSS -->
    <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{asset('assets/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/templatemo-cyborg-gaming.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
  </head>

<body>

  <!-- ***** Preloader Start ***** -->
  @include('components.preloader')
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  @include('components.header')
  <!-- ***** Header Area End ***** -->

  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">
          @yield('content')
        </div>
      </div>
    </div>
  </div>

  @include('components.footer')

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/isotope.min.js')}}"></script>
  <script src="{{asset('assets/js/owl-carousel.js')}}"></script>
  <script src="{{asset('assets/js/tabs.js')}}"></script>
  <script src="{{asset('assets/js/popup.js')}}"></script>
  <script src="{{asset('assets/js/custom.js')}}"></script>
  @yield('scripts')
  </body>
</html>
