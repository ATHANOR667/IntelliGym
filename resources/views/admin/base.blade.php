<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('style2.css')}}">
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
        .logo{
            width: 100px;
            height: 50px;
        }

    </style>
</head>
<body>
<!-- ======= navigation ======== -->
<div class="container">
    <div class="navigation container1">
        <ul>
            <li>
                <a href="" >
                    <span class="icon"> <img src="{{asset('resources/img/R.png')}}" alt="" class="logo"></span>
                    <!-- <span class="title">Brand name</span> -->
                </a>
            </li>


            <li>
                <a  href="{{route('admin.add_student',['admin'=>$admin_key])}}" >
                    <span class="icon"><i class="fi fi-sr-user-add"></i></span>
                    <span class="title">Ajouter un etudiant</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.add_free_hour',['admin'=>$admin_key])}}" >
                    <span class="icon"><i class="fi fi-sr-puzzle-alt"></i></span>
                    <span class="title">Gestion des T.P.E</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.hour_slot',['admin'=>$admin_key])}}" >
                    <span class="icon"><i class="fi fi-ss-calendar-clock"></i></span>
                    <span class="title">Gestion des heures d'ouverture</span>
                </a>
            </li>

            <li>
                <a  href="{{route('admin.list',['admin'=>$admin_key])}}" >
                    <span class="icon"><i class="fi fi-sr-shopping-cart"></i></span>
                    <span class="title">Liste des reservations</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.profil',['admin'=>$admin_key])}}" >
                    <span class="icon"><i class="fi fi-sr-user"></i></span>
                    <span class="title">Profil</span>
                </a>
            </li>

            <li>
                <a ><span class="icon"><i class="fi fi-ss-leave"></i></span><form class="formbtn" action="{{ route('admin.logout') }}" method="POST">@csrf @method('DELETE')<button class="logoutbtn" type="submit">Logout</button></form>
                </a>

            </li>


        </ul>
    </div>

    <!-- ===== main ====== -->
    <div class="main">
        <div class="topbar">
            <div class="toggle"><i class="fi fi-br-bars-staggered"></i></div>

            <div class="user">
                <img src="img/user.jpg" alt="">
            </div>
        </div>



        @yield('content')
        @livewireScripts
    </div>
</div>
</body>

<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>
<script src="{{asset('js/animations.js')}}"></script>
<script src="{{asset('js/statistiques.js')}}"></script>
</html>

