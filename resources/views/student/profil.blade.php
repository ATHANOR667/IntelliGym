<!-- ===== card ====== -->
@extends('student.base')
@section('title', 'booking')
@section('content')

<div class="contprofile">
    <div class="blockprof bprof1">
        <div class="pp2">
            <div class="divisecur">
                <div class="secur"><i class="fi fi-sr-settings-sliders"></i></div>

            </div>
        </div>
        <div class="divpp">
            <div class="blocpp bcp1">
                <img src="./resources/img/Men_bodybuilder_muscles_438817.jpg" alt="" class="pp">
            </div>
            <div class="blocpp blocpp3">
                <div class="divnom">
                    <div>
                        <h5 class="nom">{{$student->nom}}</h5>
                        <p class="email">{{$student->email}}</p>
                    </div>
                </div>
            </div>
            <div class="blocpp bcp2">
                <div class="divmenu">
                    <div class="menuop">
                        <h6><a href="{{route('user.mailcheck')}}" style="text-decoration: none;"><span><i class="fi fi-sr-settings-sliders"></i></span>Reset email</a></h6>
                    </div>
                    <div class="menuop">
                        <h6><a href="{{route('user.reset',['student'=>$student])}}" style="text-decoration: none;"><span><i class="fi fi-sr-settings-sliders"></i></span>Reset mot de passe</a></h6>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="blockprof bprof2">
        <div class="constinfo">
            {{--<div class="div1info">
                <div class="divinfo">
                    <div style="margin-bottom: 15px;">
                        <h6 class="titre">Parametre de plate-forme</h6>
                    </div>

                    <div class="divparam">
                        <h6>Compte</h6>
                        <div class="divoptions">
                            <label class="divcheck">
                                <input type="checkbox" class="checkbox">
                                <span class="slider"></span>
                            </label>
                            <p for="" class="labelcheck">mode invisible</p>
                        </div>
                        <div class="divoptions">
                            <label class="divcheck">
                                <input type="checkbox" class="checkbox">
                                <span class="slider"></span>
                            </label>
                            <p for="" class="labelcheck">Cacher mes reseaux sociaux</p>
                        </div>
                    </div>
                </div>
            </div>--}}

            <div class="div1info">
                <div class="divinfo">
                    <div style="margin-bottom: 15px;">
                        <h6 class="titre">Informations personelles</h6>
                    </div>

                  {{--  <div class="divtextinfo">
                        <p class="info">Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is
                            no. If two equally difficult paths, choose the one more painful in the short
                            term (pain avoidance is creating an illusion of equality).
                        </p>
                        <hr class="hr">
                    </div>--}}


                    <div class="divtextinfo">
                        <div class="evelinfo">
                            <h6>Nom:</h6>
                            <p>{{$student->nom}}</p>
                        </div>
                        <div class="evelinfo">
                            <h6>Prenom :</h6>
                            <p>{{$student->prenom}}</p>
                        </div>
                        <div class="evelinfo">
                            <h6>Email:</h6>
                            <p>{{$student->email}}</p>
                        </div>
                        <div class="evelinfo">
                            <h6>Taille :</h6>
                            <p></p>
                        </div>
                        <div class="evelinfo">
                            <h6>Masse:</h6>
                            <p></p>
                        </div>
                        {{--<div class="evelinfo">
                            <h6>Reseaux:</h6>
                            <div class="diviconreseau">
                                <img src="./resources/icon/facebook.png" alt="" class="iconreseaux">
                                <img src="./resources/icon/x.jpg" alt="" class="iconreseaux">
                                <img src="./resources/icon/instagram.png" alt="" class="iconreseaux">
                            </div>
                        </div>--}}

                    </div>
                </div>
            </div>
            {{--<div class="div1info">
                <div class="divinfo scroll1">
                    <div style="margin-bottom: 15px;">
                        <h6 class="titre">Paramettres</h6>
                    </div>
                    <textarea placeholder="Entrez votre description"></textarea>
                    <div>
                        <div class="divtitre">
                            <h6 class="titre">Numero de telephone</h6>
                        </div>
                        <div>
                            <input type="text" class="inputinfo">
                        </div>
                    </div>
                    <div>
                        <div class="divtitre">
                            <h6 class="titre">Email</h6>
                        </div>
                        <div>
                            <input type="text" class="inputinfo">
                        </div>
                    </div>
                    <div class="Reseaux">
                        <div class="divtitre">
                            <h6 class="titre">Resaux sociaux</h6>
                        </div>
                        <div class="divaddsociaux">
                            <h6 class="social">ajouter</h6>
                            <h6 class="social">supprimer</h6>
                        </div>
                    </div>

                    <!-- changer de mot de ppasse -->
                    <div class="contmpass">
                        <div class="divpass">
                            <input type="email" class="chmpass">
                            <input type="submit" class="btnchmps">
                        </div>
                        <div class="infochmpass">
                            <p>Pour reinitialiser votre mot de passe, veuillez entrer votre email</p>
                        </div>
                    </div>

                </div>
            </div>--}}
        </div>
    </div>
</div>

<style>

</style>
@endsection
