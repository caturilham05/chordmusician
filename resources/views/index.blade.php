@extends('layout.index')

@section('content')
<div class="main-banner">
    <div class="row">
      <div class="col-lg-7">
        <div class="header-text">
            <h1>{!!$home->title!!}</h1>
            <h2>{!!$home->intro!!}</h2>
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

@section('scripts')
<script>
    const CHORDS = ["C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "Bb", "B"];
    let scrollInterval;

    function transpose(step) {
        document.querySelectorAll("a.chord").forEach(el => {
        let chord = el.textContent.trim();
        el.textContent = transposeChord(chord, step);
        });
    }

    function transposeChord(chord, step) {
        // Pisahkan root chord dan modifikasi (m, 7, sus, /, dll)
        const match = chord.match(/^([A-G][b#]?)(.*)$/);
        if (!match) return chord;
        let root = match[1];
        let suffix = match[2] || "";

        // Jika ada slash chord (contoh: D/F#)
        if (root.includes("/")) {
        const parts = chord.split("/");
        return transposeChord(parts[0], step) + "/" + transposeChord(parts[1], step);
        }

        const index = CHORDS.findIndex(c => c === root);
        if (index === -1) return chord;
        let newIndex = (index + step + CHORDS.length) % CHORDS.length;
        return CHORDS[newIndex] + suffix;
    }

    function toggleScroll() {
        if (scrollInterval) {
        clearInterval(scrollInterval);
        scrollInterval = null;
        alert("Auto scroll stopped");
        } else {
        let speed = prompt("Masukkan kecepatan scroll (angka kecil = lebih cepat)", "50");
        scrollInterval = setInterval(() => {
            window.scrollBy(0, 1);
        }, Number(speed));
        }
    }
</script>
