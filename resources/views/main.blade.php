<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Duck Yeah</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        html, body, #action-page {
            background-size: contain;
            height: 100vh;
            padding: 0;
            margin: 0;
        }

        #cover-page {
            background: url('/images/duck_yeah_logo_full.png');
            background-repeat: no-repeat;
            background-size: auto;
            height: 100vh;
            padding: 0;
            margin: 0 auto; 
        }

        .duck-green {
            background-color: rgb(4, 117, 48);
        }

        .event-container {
            color: white;
            background: linear-gradient(270deg, #005817, #008c25, #00c634);
        }

        .event-container h1 {
            font-size: 3.5rem;
        }

        .event-container h2 {
            font-size: 2rem;
        }

        .message-container {
            height: 40vh;
        }

        .gif-container {
            height: 60vh;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0" id="app">
        <div class="row event-container" id="action-page" v-show="isPlayingSomething">
            <div id="video-placeholder">
            </div>
            <div class="col-md-8 offset-md-2 mt-3 message-container">
                <h1>@{{event_description}}</h1>
                <h2>@{{custom_description}}</h2>
            </div>
            <div class="col-md-12 gif-container p-0 m-0" v-bind:style="{ backgroundImage: 'url(' + giphy_url + ')' }">
            </div>
        </div>
        <div class="row text-center duck-green" v-show="!isPlayingSomething">
            <div id="cover-page" class="col-md-6"></div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- We are going to decouple this main page from the main Vue app, as its the isolated TV page -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>

    <script>

        // load Youtube API code asynchronously
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('89c3b8639c5dad386c56', {
            cluster: 'eu',
            forceTLS: true
        });

        var channel = pusher.subscribe('duck-yeah');
            channel.bind('duck-alert', function(data) {
                app.giphy_url = '';
                app.youtube_url = '';

                if (data.alert && data.alert.duckData) {
                    app.resetData();
                    app.processAlertToScreen(data.alert.duckData);
                } else {
                    console.log('Something went wrong with fetching new data');
                    console.log(data);
                }
        });

        // Vue application
        const app = new Vue({
            el: '#app',
            data: {
                messages: [],
                giphy_url: '',
                youtube_url: '',
                event_description: '',
                custom_description: '',
                pending_data: {},
                isPlayingSomething: false
            },
            methods: {
                processAlertToScreen: processAlertToScreen,
                resetData: function() {
                    this.giphy_url = '';
                    this.youtube_url = '';
                    this.event_description = '';
                    this.custom_description = '';
                    this.pending_data = {};
                    this.isPlayingSomething = false;
                }
            }
        });

        var intro_player;
        var custom_player;
        var intro_done = false;
        var custom_done = false;

        function processAlertToScreen(data) {
            this.pending_data = data;
            this.event_description = data.event_description;
            this.custom_description = data.custom_description;

            intro_done = false;
            custom_done = false;
            // This is the intro
            intro_player = new YT.Player('video-placeholder', {
                height: '1',
                width: '1',
                videoId: 'gUFF5A766K0',
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChangeIntro
                }
            });
        }
        // 3 second intro, 12 second main song / giphy

        // 4. The API will call this function when the video player is ready.
        function onPlayerReady(event) {
            event.target.playVideo();
        }

        // 5. The API calls this function when the player's state changes.
        //    The function indicates that when playing a video (state=1),
        //    the player should play for six seconds and then stop.
        
        function onPlayerStateChangeIntro(event) {
            if (event.data == YT.PlayerState.PLAYING && !intro_done) {
                setTimeout(stopIntroVideo, 4000);
                intro_done = true;
            }
        }

        function stopIntroVideo() {
            intro_player.stopVideo();
            initNewDiv();
            startCustomVideo();
        }

        function stopCustomVideo() {
            app.giphy_url = '';
            app.youtube_url = '';
            initNewDiv();
            app.isPlayingSomething = false;
        }

        function initNewDiv() {
            var new_div = document.createElement('div');
            var currentIFrame = document.getElementById('video-placeholder');
            currentIFrame.parentNode.insertBefore(new_div, currentIFrame);
            currentIFrame.remove();
            new_div.id = 'video-placeholder';
        }

        function startCustomVideo() {
            custom_player = new YT.Player('video-placeholder', {
                height: '1',
                width: '1',
                videoId: 'nZXRV4MezEw',
                events: {
                    'onReady': function(event) {
                        event.target.playVideo();
                    },
                    'onStateChange': function(event) {
                        if (event.data == YT.PlayerState.PLAYING) {
                            app.giphy_url = app.pending_data.giphy_url;
                            app.isPlayingSomething = true;
                            setTimeout(stopCustomVideo, 15000);
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>