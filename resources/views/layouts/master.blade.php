<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--  <meta name="viewport" content="initial-scale=1, maximum-scale=1">  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="language" content="fr-FR" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="geo.region" content="FR" />
    <meta name="geo.placename" content="Ozoir-la-Ferri&egrave;re" />
    <meta name="geo.position" content="48.762292;2.663712" />
    <meta name="ICBM" content="48.762292, 2.663712" />

    <meta name="description" content="Tous concernant BC Ozoir - Bowling Club Ozoir, informations, tournois, ligues, membres, listing, photos, vidéos, tournois future et plus. BC Ozoir est affilié à la FFBSQ et est présent en divisions régionales." />
    <meta name="keywords" content="bowling, Ozoir, bowling club, bowling ozoir, bowling 77, club, bcozoir, tournoi, amitie" />
    @yield('keywords')
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,600,700,700i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.css') }}">
    <link rel="stylesheet" href="{{ asset('slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
    @if (isset($banner) && isset($banner->path))
        <style>
            #header__img--personalized {
                background-image: url("{{asset('storage' . $banner->path)}}");
            }
        </style>
    @endif
    @yield('styles')

    <title>Amicale Bowling Club I.D.F.</title>
</head>
<body>
    <audio class="content__audio" id="audio" autoplay loop >
        <source src="{{ isset($music_link->path) ? asset('storage' . $music_link->path) : asset('music/music.mp3') }}" type="audio/mpeg">
            <p>Votre navigateur ne prend pas en charge l'audio HTML.</p>
    </audio>
    <div class="container">
        @include('layouts.partials._header')
        @include('layouts.partials._main')
        @include('layouts/partials/_footer')

        <script src="{{ asset('bower_components/AdminLTE/plugins/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.js') }}"></script>
        <script src="{{ asset('bower_components/AdminLTE/plugins/fullcalendar/lang/fr.js') }}"></script>
        <script src="{{ asset('slick/slick.min.js') }}"></script>
        <script src="{{ asset('js/lightbox.min.js') }}"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
        <script src="{{ asset(mix('js/master.js')) }}"></script>
        <script>
            $(document).ready(function() {
                $('#calendar').fullCalendar({
                    lang: 'fr',
                    header: {
                            left:   'prev',
                            center: 'title',
                            right:  'next'
                        },
                    height: 250,
                    events: "{{ route('eventcalendar') }}",
                    color: 'blue', 
                    textColor: 'black',
                });
            });

            // let audioState = JSON.parse(localStorage.getItem('audioState'));
            let audio_player = document.getElementById('audio');
            
            let volume = {!! isset($music_volume->description) ? json_encode($music_volume->description, JSON_HEX_TAG)  : json_encode('0', JSON_HEX_TAG) !!};
            document.getElementById("audio").volume = volume;
            
            audio_player.play();

            // if (audioState != null && audioState == true) {
            //     audio_player.play();
            // }

            // audio_player.addEventListener("play", () => {
            //     localStorage.setItem('audioState', JSON.stringify(true));
            // });

            // audio_player.addEventListener("pause", () => {
            //     localStorage.setItem('audioState', JSON.stringify(false));
            // });
        </script>
        @yield('scripts')
    </div>
</body>
</html>