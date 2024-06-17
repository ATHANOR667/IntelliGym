<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--    <link rel="stylesheet" href="{{asset('public/app.css')}}">--}}
    <link rel="stylesheet" href="{{asset('style.css')}}">
    @livewireStyles
    <title>@yield('title')</title>
    <style>
        .calendar {
            display: flex;
            flex-direction: row;
        }

        .day {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hour {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px;
            background-color: lightgray;
            border-radius: 5px;
            margin-bottom: 5px;
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
<script src="{{asset('js/animelogin.js')}}"></script>
</html>
