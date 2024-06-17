<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel='stylesheet'
          href='https://cdn-uicons.flaticon.com/2.2.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet'
          href='https://cdn-uicons.flaticon.com/2.2.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <title>Document</title>
</head>
<header class="header1">
    <div class="divbar">
        <div class="divlogo">
            <img src="{{asset('resources/img/R.png')}}" alt="" class="logo">
        </div>
        <ul class="ulbar">
            <li class="libar">
                <i class="fi fi-ss-plug-connection"></i>
                <a href="{{route('user.login')}}" class="menu">Se connecter</a>
            </li>

            <div class="close">
                <i class="fi fi-rr-circle-xmark"></i>
            </div>
        </ul>
        <div class="pluss">
            <i class="fi fi-br-bars-staggered"></i>
        </div>
    </div>
</header>

<body>
<div class="container1">

    <div class="vitrine">
        <div>
            <h1 class="title">
                Salle de sport des ecoles francaises
            </h1>
        </div>

        <div class="divpub">
            <div class="divimgpub">
                <img src="{{asset('resources/img/equip1.png')}}" alt="" class="imgpub">
            </div>
            <div class="divtextpub">
                <p class="textpub">
                    Ici, chaque séance est une aventure, chaque sueur une médaille d'honneur. Que vous soyez novice
                    ou athlète aguerri, nos programmes personnalisés et notre ambiance motivante vous propulseront
                    vers des hauteurs inexplorées.
                </p>
            </div>
        </div>
        <div class="divpub">
            <div class="divimgpub">
                <img src="{{asset('resources/img/equip2.png')}}" alt="" class="imgpub2">
            </div>
            <div class="divtextpub">
                <p class="textpub">
                    Nous comprenons que le chemin vers la réussite est pavé de défis, et c’est pourquoi nos espaces
                    inspirants et nos équipements à la fine pointe sont conçus pour vous mener au-delà de vos
                    limites. Notre communauté est votre nouvelle famille, prête à vous soutenir et à célébrer chaque
                    victoire. Ne rêvez plus votre vie, vivez vos rêves. C'est votre moment. C'est votre lieu.
                </p>
            </div>
        </div>
        <div class="divpub">
            <div class="divimgpub">
                <img src=".{{asset('resources/img/equip3.png')}}" alt="" class="imgpub3">
            </div>
            <div class="divtextpub">
                <p class="textpub">
                    La véritable force réside dans la capacité à rester discipliné, jour après jour. Plus qu'une
                    salle de sport; c'est un sanctuaire où la discipline se transforme en puissance. Nos
                    entraînements, conçus pour tous les niveaux, vous poussent à vous dépasser et à rester engagé
                    envers vos objectifs.
                </p>
            </div>
        </div>






    </div>

    <div class="vitrine2">
        <div class="cercle1">
            <a href="" class="divimage ecema"><img src="{{asset('resources/img/ecema.png')}}" alt="" class="ecoles"></a>
            <div class="cercle2">
                <a href="" class="divimage cparis"><img src="{{asset('resources/img/R.png')}}" alt="" class="ecoles"></a>
                <div class="cercle3">
                    <a href="" class="divimage keyce"><img src="{{asset('resources/img/keyce.jpeg')}}" alt="" class="ecoles"></a>
                    <a href="" class="divimage digital"><img src="{{asset('resources/img/Logo-dc-2017-1024x957.png')}}" alt=""
                                                             class="ecoles"></a>
                </div>
            </div>
        </div>




        <div class="continscrip" style="display: none">
            <div class="divinscrip inscription">
                <div class="titreinscriotion">
                    <h2>S'inscrire</h2>
                </div>
                <div class="divoptioninscript">
                    <img src="../../../public/resources/icon/facebook.png" alt="" class="optioninscript">
                    <img src="../../../public/resources/icon/apple.png" alt="" class="optioninscript">
                    <img src="../../../public/resources/icon/google.png" alt="" class="optioninscript">
                </div>

                <h4 class="ou">ou</h4>

                <form action="" class="forminscrip">
                    <div class="divinput">
                        <input type="file" class="input01" aria-describedby="photo">
                        <input type="text" class="input01" placeholder="Nom">
                        <input type="email" class="input01" placeholder="E-mail">
                        <input type="password" class="input01" placeholder="mot de passe">

                        <div class="radio">
                            <input type="checkbox" class="form-check-input">
                            <p>En continuant, vous reconnaisez avoir lu notre <span><a href=""
                                                                                       class="liens">politique de confidentialite</a></span></p>
                        </div>

                        <div class="divbtninput">
                            <input type="submit" class="btninput" value="S'inscrire">
                        </div>
                    </div>
                    <div class="changecon">
                        <p>vous avez deja un compte?<span>
                                    <p class="liens liensconnexion" style=" font-weight: bold; cursor: pointer;">Se connecter</p>
                                </span></p>
                    </div>
                </form>

            </div>
            <div class="divinscrip connexion">
                <div class="titreinscriotion">
                    <h2>Se connecter</h2>
                </div>
                <div class="divoptioninscript">
                    <img src="../../../public/resources/icon/facebook.png" alt="" class="optioninscript">
                    <img src="../../../public/resources/icon/apple.png" alt="" class="optioninscript">
                    <img src="../../../public/resources/icon/google.png" alt="" class="optioninscript">
                </div>
                <h4 class="ou">ou</h4>

                <form action="" class="forminscrip">
                    <div class="divinput">


                        <input type="email" class="input01" placeholder="E-mail">
                        <input type="password" class="input01" placeholder="mot de passe">

                        <div style="margin-top: 25px;">
                            <a href="" style="text-decoration: none;">mot de passe oublier?</a>
                        </div>

                        <div class="divbtninput">
                            <input type="submit" class="btninput" value="S'inscrire">
                        </div>
                    </div>
                    <div class="changecon">
                        <p>vous n'avez pas de compte?<span><p class="liens lieninscription" style=" font-weight: bold;  cursor: pointer;">S'inscrire</p></span></p>
                    </div>
                </form>
            </div>

        </div>
    </div>


</div>
</body>
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/animations.js')}}"></script>

</html>


