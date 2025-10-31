@extends('layout.index')

@section('content')
<!-- ***** Featured Start ***** -->
<div class="feature-banner header-text">
    <div class="row">
        @php
            // Ambil ID dari link embed YouTube
            function getYoutubeId($embed)
            {
                preg_match('/embed\/([^"?]+)/', $embed, $matches);
                return $matches[1] ?? '';
            }
            $youtubeId = getYoutubeId($chord->link_youtube);
        @endphp
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
                <h4 style="text-transform: uppercase">other {{$chord->band}}</h4>
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
        <div style="text-align: center;">
            <h4>{!!$chord->band!!} - {!! $chord->title !!}</h4>
        </div>
        <div class="controls mb-3 mt-3">
            <button id="transdown" class="btn btn-secondary">Transpose -</button>
            <button id="transup" class="btn btn-secondary">Transpose +</button>
            <input type="button" data-csize="-1" value="Font Size -" class="btn btn-light" />
            <input type="button" data-csize="1" value="Font Size +" class="btn btn-light" />

            <!-- Tombol dan pengaturan autoscroll -->
            <button id="scrollBtn" class="btn btn-warning">Start Auto Scroll</button>
            <input type="range" id="scrollSpeed" min="10" max="200" value="60" style="width:150px; vertical-align:middle;">
            <label for="scrollSpeed" class="ms-1">Speed</label>
        </div>

        <main id="song" style="color: white;">
            <div class="telabox">
                <div class="no-copy-overlay"></div>
                @php
                    $content = $chord->content;
                    $clean = strip_tags($content);

                    $pattern = '/(?<![A-Za-z0-9\/])([A-G][#b]?(?:maj|min|dim|aug|sus|add|m)?[0-9]*(?:b5|-5)?(?:\/[A-G][#b]?)?)(?![A-Za-z0-9#\/])/i';

                    $formatted = preg_replace_callback($pattern, function ($matches) {
                        $chord = $matches[1];
                        if (ctype_upper($chord[0])) {
                            $class = 'tbi-' . str_replace(['#', 'b', '/'], ['cis', 'b', '-'], $chord);
                            return '<a class="chord tbi-tooltip">' . $chord . '<span class="custom ' . $class . '"></span></a>';
                        }
                        return $chord;
                    }, $clean);
                @endphp
                <pre class="lyrics">{!! $formatted !!}</pre>
            </div>
        </main>
    </div>
</div>

<!-- Modal chord -->
<!-- Popover mini untuk chord -->
<div id="chordPopover"
     style="display:none; position:absolute; z-index:9999;
            background:white; border:1px solid #ccc; border-radius:8px;
            padding:1px; box-shadow:0 4px 10px rgba(0,0,0,0.15);">
    {{-- <h6 id="chordPopoverTitle" style="margin:0; font-weight:bold; color: #000; text-align: center"></h6> --}}
    <img id="chordPopoverImage" src="" alt="Chord" style="max-width:100px; margin-top:1px;">
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

            let scrollActive = false;
            let scrollSpeed = 60; // default

            function autoScroll() {
                if (!scrollActive) return;

                const step = Number(scrollSpeed) / 20;
                window.scrollBy(0, step);

                // berhenti kalau sudah di bawah
                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                    stopAutoScroll();
                    return;
                }

                // panggil frame berikutnya (lebih halus dan jalan di iOS)
                requestAnimationFrame(autoScroll);
            }

            function startAutoScroll(speed) {
                scrollSpeed = speed;
                scrollActive = true;
                requestAnimationFrame(autoScroll);
            }

            function stopAutoScroll() {
                scrollActive = false;
                const btn = document.getElementById('scrollBtn');
                btn.textContent = 'Mulai Auto Scroll';
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-warning');
            }

            const btn = document.getElementById('scrollBtn');
            const speedInput = document.getElementById('scrollSpeed');

            btn.addEventListener('click', function () {
                const speed = speedInput.value;
                if (scrollActive) {
                    stopAutoScroll();
                } else {
                    startAutoScroll(speed);
                    btn.textContent = 'Stop Auto Scroll';
                    btn.classList.remove('btn-warning');
                    btn.classList.add('btn-danger');
                }
            });

            speedInput.addEventListener('input', function () {
                scrollSpeed = this.value;
            });

            // ✅ hentikan scroll saat user sentuh layar
            window.addEventListener('touchstart', stopAutoScroll, { passive: true });
            window.addEventListener('wheel', stopAutoScroll, { passive: true });

            $(document).on('click', '.tbi-tooltip', function (e) {
                e.stopPropagation(); // biar gak langsung tertutup

                const chord = $(this).text().trim()
                .replace('#', 'sharp')
                .replace('/', 'on')
                .replace('-', '_');

                const popover = $('#chordPopover');
                const title = $('#chordPopoverTitle');
                const img = $('#chordPopoverImage');

                const notFoundPath = '/assets/images/chords/tab-not-found.png';
                const pngPath = '/assets/images/chords/' + chord + '.jpg';

                title.text($(this).text().trim());
                img.attr('src', pngPath);

                img.off('error').on('error', function() {
                    $(this).attr('src', notFoundPath);
                });

                const offset = $(this).offset();
                const height = $(this).outerHeight();

                popover.css({
                    top: offset.top + height + 5,
                    left: offset.left,
                    display: 'block'
                });
            });

            $(document).on('click', function (e) {
                if (!$(e.target).closest('#chordPopover, .tbi-tooltip').length) {
                    $('#chordPopover').hide();
                }
            });
        });
    });

    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey && ['c', 'u', 's'].includes(e.key.toLowerCase())) ||
            (e.ctrlKey && e.shiftKey && ['i', 'j'].includes(e.key.toLowerCase()))) {
            e.preventDefault();
        }
    });
</script>

@if ($chord->link_youtube)
    @php
        preg_match('/embed\/([^"?]+)/', $chord->link_youtube, $matches);
        $youtubeId = $matches[1] ?? '';
    @endphp
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "VideoObject",
      "name": "{{ $chord->band }} - {{ $chord->title }}",
      "description": "{{ $chord->description ?? 'Chord gitar lengkap dari ChordMusician.' }}",
      "thumbnailUrl": "https://img.youtube.com/vi/{{ $youtubeId }}/hqdefault.jpg",
      "uploadDate": "{{ $chord->created_at->format('Y-m-d') }}",
      "contentUrl": "https://www.youtube.com/watch?v={{ $youtubeId }}",
      "embedUrl": "https://www.youtube.com/embed/{{ $youtubeId }}",
      "publisher": {
        "@type": "Organization",
        "name": "ChordMusician",
        "logo": {
          "@type": "ImageObject",
          "url": "https://chordmusician.com/favicon.png"
        }
      }
    }
    </script>
@endif
