<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    {{--    <script src="../tablette/js/jquery.js"></script>--}}
    <script src="https://cdn.tiny.cloud/1/i4il4iq9pralls0h1cuuyd6y32c14gfbi5xeaif13afvu1zf/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
    <title>@yield('title')</title>
</head>
<style>
    .details .recentOrders table tr td:hover{
        /* background: none; */
        /* color: var(--white); */
        border-radius: 100%;

    }
</style>

<body>
<!-- ======= navigation ======== -->
<div class="container">
    <div class="navigation container1">
        <ul>
            <li>
                <a href="">
                    <span class="icon"><img class="icon1" src="./resources/img/R.png" alt=""></span>
                    <!-- <span class="title">Brand name</span> -->
                </a>
            </li>



            <li>
                <a href="{{route('user.booking',['student'=>$user_key])}}" >
                    <span class="icon"><i class="fi fi-sr-shopping-cart"></i></span>
                    <span class="title">Reservations</span>
                </a>
            </li>

            <li>
                <a href="{{route('user.profil',['student'=>$user_key])}}" >
                    <span class="icon"><i class="fi fi-sr-user"></i></span>
                    <span class="title">Profil</span>
                </a>
            </li>

            <li>
                <a ><span class="icon"><i class="fi fi-ss-leave"></i></span><form class="formbtn" action="{{ route('user.logout') }}" method="POST">@csrf @method('DELETE')<button class="logoutbtn" type="submit">Logout</button></form>
                </a>

            </li>

        </ul>
    </div>

    <!-- ===== main ====== -->
    <div class="main">
        <div class="topbar">
            <div class="toggle"><i class="fi fi-br-bars-staggered"></i></div>
        </div>
        <div >
            @yield('content')
        </div>

        @livewireScripts

    </div>
</div>

<!-- ============ script ============== -->
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>
<script src="{{asset('js/animations.js')}}"></script>
<script src="{{asset('js/statistiques.js')}}"></script>

</body>

</html>


