<div style="width: 100%; height: 100%;">
    {{-- The Master doesn't talk, he acts. --}}
    <div >



        {{--        <div wire:loading>--}}
        {{--            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" stroke="#000000">--}}
        {{--                <g fill="none" fill-rule="evenodd">--}}
        {{--                    <g transform="translate(2 2)" stroke-width="4">--}}
        {{--                        <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>--}}
        {{--                        <path d="M36 18c0-9.94-8.06-18-18-18">--}}
        {{--                            <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"/>--}}
        {{--                        </path>--}}
        {{--                    </g>--}}
        {{--                </g>--}}
        {{--            </svg>--}}
        {{--        </div>--}}

    </div>



    <div class="calendar details" >
        <div class="recentOrders" style=" min-height: 50px;">
            <div wire:loading > <h2><strong>Chargement....</strong></h2></div>

            <div class="cardHeader">
                <h2>Reservations </h2><br>
                <span>Semaine du {{ $jours[0] }} au {{ $jours[1] }} </span>
                <select class="selection1 " name="week" wire:change="setWeek($event.target.value)">
                    <option class="optio" value="{{$weeks[0]}}">Semaine en cours </option>
                    <option class="optio" value="{{$weeks[1]}}">Semaine Prochaine</option>
                </select>
            </div>
            <table>
                <thead>
                <tr class="trview1">
                    <th>Heures</th>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                    <th>samedi</th>
                    <th>dimanche</th>
                </tr>
                </thead>
                <tbody>

                @for($i = 1; $i < 8; $i++)
                    <tr>
                        <td>{{ $slots[$i] }}</td>
                        @for($j = 1; $j < 8; $j++)
                            @php
                                $id = ($i - 1) * 7 + $j;
                            @endphp
                                <td >
                                    <div class="td">

                                    <button  class="b" wire:click="list({{ $id }})">
                                        <div class="checkbox-wrapper divheure">

                                        </div>
                                    </button>
                                    </div>
                                </td>
                        @endfor
                    </tr>
                @endfor
                </tbody>
            </table>

        </div>
        <!-- ========== new customer ========== -->
        <div class="recentCustomers">
            <div class="cardHeader">
                <h2>Reservations</h2>
            </div>

            <table>
                <tr>
                    <td width="60px">
                        <h4>Etudiant</h4>
                    </td>
                    <td><span class="statuts">Ecole</span></td>
                    </td>
                </tr>

                @foreach($etudiants as $etudiant)
                    <div wire:loading > <strong>Chargment....</strong></div>
                    <tr>
                        <td width="70%">
                            <h4>{{$etudiant->nom}}-{{$etudiant->prenom}} <br> <span>{{$etudiant->niveau}}</span></h4>
                        </td>
                        <td width="30%">
                           <span>{{$etudiant->nom_ecole}}</span>
                        </td>
                    </tr>
                @endforeach

            </table>
        </div>

    </div>
    <style>
        /*.calendar {*/
        /*    width: 100%;*/
        /*    margin: 20px 0;*/
        /*}*/

        /* =============== Order Details List ============= */
        /*# sourceMappingURL=style2.css.map */

        /*input[type="checkbox"] {*/
        /*    appearance: none;*/
        /*    -webkit-appearance: none;*/
        /*    -moz-appearance: none;*/
        /*    width: 100%;*/
        /*    height: 50px;*/
        /*    outline: none;*/
        /*    cursor: pointer;*/
        /*}*/

        .b{
            background-color: rgba(96, 98, 96, 0.56);
            color: #fff;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: auto;
            height: auto;
            outline: none;
            cursor: pointer;
            border-radius: 50%;
        }


    </style>
</div>


