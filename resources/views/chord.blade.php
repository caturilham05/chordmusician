@extends('layout.index')

@section('content')
<!-- ***** Featured Start ***** -->
<div class="feature-banner header-text">
    <div class="row">
        <div class="col-lg-8">
            <div class="frame_youtube">
                @if ($chord->link_youtube)
                    <div class="video-wrapper">
                        {!! $chord->link_youtube !!}
                    </div>
                @else
                    <img src="{{asset('assets/images/notfound.png')}}" alt="No Video Available" class="img-fluid" />
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="heading-section detail">
                <h4 style="text-transform: uppercase">CHORD {{$chord->band}}</h4>
            </div>
            <ul>
                @foreach ($playlistsByBand as $playlist)
                    <li><a href="{{route('chord', [
                        'year' => $playlist->published_at->format('Y'),
                        'month' => $playlist->published_at->format('m'),
                        'slug' => $playlist->slug
                    ])}}">{{$playlist->title}}</a></li>
                    <hr style="color: white" />
                @endforeach
                <div class="mt-4 mb-4 pagination-custom">
                    {{ $playlistsByBand->links() }}
                </div>
            </ul>
            <div style="text-align: center; padding: 10px; text-transform: uppercase;">
                <img src="{{asset('assets/images/saweria.jpg')}}" alt="saweria" class="img-fluid" style="width: 200px; max-width: 100%;"/>
                <h5 style="margin-top: 1rem"><a href="https://saweria.co/chordmusician" target="blank">Link Saweria Request Chord</a></h5>
            </div>
        </div>
    </div>
</div>
<!-- ***** Featured End ***** -->
<hr style="color: white" />
<div class="content">
    <div class="row">
        <div style="text-align: center; text-transform: uppercase;">
            <h4>{!!$chord->band!!} - {!! $chord->title !!}</h4>
        </div>
        <div class="controls mb-3 mt-3">
            <button id="transdown" class="btn btn-secondary">Transpose -</button>
            <button id="transup" class="btn btn-secondary">Transpose +</button>
            <input type="button" data-csize="-1" value="A-" class="btn btn-light" />
            <input type="button" data-csize="1" value="A+" class="btn btn-light" />
            <button onclick="toggleScroll()" class="btn btn-warning">Auto Scroll</button>
        </div>

        <main id="song" style="color: white;">
            <div class="telabox">
                <div class="no-copy-overlay"></div> <!-- overlay pelindung -->
                @php
                    $content = $chord->content;
                    $clean = strip_tags($content);

                    // Perbaikan: regex agar D/F# tidak terpotong
                    // $pattern = '/([A-G][#b]?m?(?:maj|min|sus|dim|aug|add|m7|7|9|11|13)?(?:\/[A-G][#b]?)?)/';
                    // $pattern = '/(?<![A-Za-z0-9\/])([A-G][#b]?m?(?:maj|min|sus|dim|aug|add|m7|7|9|11|13)?(?:\/[A-G][#b]?)?)(?![a-zA-Z0-9#\/])/';
                    // $pattern = '/(?<![A-Za-z0-9\/])([A-G][#b]?(?:maj|min|dim|aug|sus|add|m)?[0-9]*(?:b5)?(?:\/[A-G][#b]?)?)(?![A-Za-z0-9#\/])/i';
                    $pattern = '/(?<![A-Za-z0-9\/])([A-G][#b]?(?:maj|min|dim|aug|sus|add|m)?[0-9]*(?:b5|-5)?(?:\/[A-G][#b]?)?)(?![A-Za-z0-9#\/])/i';

                    $formatted = preg_replace_callback($pattern, function ($matches) {
                        $chord = $matches[1];
                        $class = 'tbi-' . str_replace(['#', 'b', '/'], ['cis', 'b', '-'], $chord);
                        return '<a class="chord tbi-tooltip">' . $chord . '<span class="custom ' . $class . '"></span></a>';
                    }, $clean);
                @endphp
                <pre class="lyrics">{!! $formatted !!}</pre>
            </div>
        </main>
    </div>
</div>
@endsection

@section('scripts')
<script>
    window.addEventListener("DOMContentLoaded", function () {
        jQuery(document).ready(function ($) {
            const kuncigitar = [
                "C", "C#", "D", "D#", "E", "F", "F#",
                "G", "G#", "A", "Bb", "B",
                "C", "C#", "D", "D#", "E", "F", "F#",
                "G", "G#", "A", "A#", "B"
            ];
            const kuncigitarRegex = /A#|C#|D#|F#|G#|Ab|Bb|Db|Eb|Gb|A|B|C|D|E|F|G/g;

            // ==== Fungsi umum untuk transpose ====
            function transpose(step) {
                $(".tbi-tooltip").each(function () {
                    const el = $(this);
                    const html = el.html();
                    let result = "";
                    let parts = html.split(kuncigitarRegex);
                    let match;
                    let i = 0;

                    while ((match = kuncigitarRegex.exec(html)) !== null) {
                        const chord = match[0];
                        const index = kuncigitar.indexOf(chord, 1);
                        result += parts[i++] + kuncigitar[index + step];
                    }

                    result += parts[i] || "";

                    // Normalisasi enharmonik
                    result = result
                        .replace(/Gb/g, "F#")
                        .replace(/Ab/g, "G#")
                        .replace(/Bb/g, "A#")
                        .replace(/Db/g, "C#")
                        .replace(/Eb/g, "D#");

                    // Update elemen chord
                    el.html(result)
                      .removeClass()
                      .addClass("tbi-tooltip " + result);

                    // Update span tooltip
                    const chordText = el.text().trim();
                    const span = el.find("span");
                    if (chordText.includes("/")) {
                        const base = chordText.split("/")[0].replace("#", "cis");
                        span.attr("class", "custom tbi-" + base);
                    } else {
                        span.attr("class", "custom tbi-" + chordText.replace("#", "cis"));
                    }
                });
            }

            // ==== Tombol transpose ====
            $("#transup").on("click", function () {
                transpose(1);
            });

            $("#transdown").on("click", function () {
                transpose(-1);
            });

            // ==== Ubah ukuran font ====
            function changeFontSize(delta) {
                $(".telabox, pre").each(function () {
                    let size = parseInt($(this).css("font-size"));
                    $(this).css("font-size", size + delta + "px");
                });
            }

            $('input[type="button"]').on("click", function () {
                changeFontSize(parseInt($(this).data("csize")));
            });

            let isScrolling = false;
            let scrollInterval;

            window.toggleScroll = function () {
                if (!isScrolling) {
                    isScrolling = true;
                    scrollInterval = setInterval(() => {
                        // scroll seluruh halaman ke bawah
                        window.scrollBy(0, 1);

                        // berhenti otomatis kalau sudah di bawah
                        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                            clearInterval(scrollInterval);
                            isScrolling = false;
                        }
                    }, 30); // ubah 30 → lebih kecil = lebih cepat
                } else {
                    clearInterval(scrollInterval);
                    isScrolling = false;
                }
            };
        });
    });

    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    document.addEventListener('keydown', function(e) {
        // Ctrl+C, Ctrl+U, Ctrl+S, Ctrl+Shift+I, Ctrl+Shift+J
        if ((e.ctrlKey && ['c', 'u', 's'].includes(e.key.toLowerCase())) ||
            (e.ctrlKey && e.shiftKey && ['i', 'j'].includes(e.key.toLowerCase()))) {
            e.preventDefault();
        }
    });
</script>
