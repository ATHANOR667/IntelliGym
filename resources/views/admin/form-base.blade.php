<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{asset('style2.css')}}">
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <link rel='stylesheet'
          href='https://cdn-uicons.flaticon.com/2.2.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet'
          href='https://cdn-uicons.flaticon.com/2.2.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel='stylesheet'
          href='https://cdn-uicons.flaticon.com/2.2.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>

    <script src="https://cdn.tiny.cloud/1/i4il4iq9pralls0h1cuuyd6y32c14gfbi5xeaif13afvu1zf/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
    <title>@yield('title')</title>
    <style>
        .calendar {
            display: flex;
            flex-direction: row;
        }
        .day {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .hour {
            background-color: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            margin: 0;
            font-size: inherit;
            color: inherit;
            text-decoration: underline;
        }

        .hour:focus,
        .hour:active {
            outline: none;
        }

        .hour.selected {
            background-color: green;
            color: white;
        }
        .hour span {
            margin: 0;
        }

    </style>
</head>
<body>
<div class="continscrip2">
    <header class="header1">
        <div class="divbar">
            <div class="divlogo">
                <img src="{{asset('resources/img/R.png')}}" alt="" class="logo">
            </div>

        </div>
    </header>
    @yield('content')
</div>

@livewireScripts
</body>

<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>
<script src="{{asset('js/animelogin.js')}}"></script>
<script src="{{asset('js/statistiques.js')}}"></script>
</html>

