<div>

    {{-- PARTIE DU COMPOSANT DEDIEE A L'ATTRIBUTION DES CLASSES ET DES SEMAINES --}}
    <div >



        <div wire:loading>
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" stroke="#000000">
                <g fill="none" fill-rule="evenodd">
                    <g transform="translate(2 2)" stroke-width="4">
                        <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
                        <path d="M36 18c0-9.94-8.06-18-18-18">
                            <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"/>
                        </path>
                    </g>
                </g>
            </svg>
        </div>

    </div>

    {{--TABLEAU D'AJUT/SUPPRESSION D'HEURES LIBRE EN LUI MEME  --}}


    @if($CDS)
        <div class="calendar details" x-data="{ to_add: $wire.entangle('to_add'), to_delete: $wire.entangle('to_delete') }" style=" display: flex !important; ">
            <div class="recentOrders" style=" min-height: 50px; width: 100%;">
                <div class="cardHeader">
                    <div style="display: flex; ">
                        <select class="selection1" name="classe" wire:change="setClass($event.target.value)">
                            @foreach($classes as $cla)
                                <option value="{{ $cla['id'] }}">{{ $cla['niveau'].$cla['numero'].$cla['specialite'] }}</option>
                            @endforeach
                        </select>

                        <select class="selection1" style="margin-left: 7px;" name="week" wire:change="setWeek($event.target.value)">
                            <option value="{{$weeks[0]}}">Semaine en cours </option>
                            <option value="{{$weeks[1]}}">Semaine Prochaine</option>
                        </select>
                    </div>

                    <div x-show="to_add.length > 0 || to_delete.length > 0">
                        <button class="btnre" x-on:click="$wire.exec([...new Set(to_add.filter(id => !to_delete.includes(id)))], to_delete)">
                            Soumettre
                        </button>
                        {{--                <span x-text="'Contenu de to_add : ' + JSON.stringify([...new Set(to_add.filter(id => !to_delete.includes(id)))])"></span>--}}
                        {{--                <span x-text="'Contenu de to_delete : ' + JSON.stringify(to_delete)"></span>--}}
                    </div>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Semaine du {{ $jours[0] }} au {{ $jours[1] }} des {{$class->niveau.$class->numero.$class->specialite}}</th>
                        <th>Lundi</th>
                        <th>Mardi</th>
                        <th>Mercredi</th>
                        <th>Jeudi</th>
                        <th>Vendredi</th>
                        <th>........</th>
                        <th>Samedi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>18h a 22h</td>
                        @for($j = 1; $j < 6; $j++)
                            @php
                                $i =3 ; $id = ($i - 1) * 5 + $j;
                            @endphp
                            @if($HeureLibreEditable !== null && in_array($id, $HeureLibreEditable))
                                <td>
                                    <div class="td">
                                        <div class="checkbox-wrapper divheure">
                                            <input type="checkbox" x-model="to_delete" :value="{{$id}}" class="a">
                                        </div>
                                    </div>
                                </td>
                            @else
                                <td>
                                    <div class="td">
                                        <div class="checkbox-wrapper divheure">
                                            <input type="checkbox" x-model="to_add" :value="{{$id}}" class="b">
                                        </div>
                                    </div>
                                </td>
                            @endif
                        @endfor
                        <td>8h30 a 12h30</td>
                        @if($HeureLibreEditable !== null && in_array(16, $HeureLibreEditable))
                            <td>
                                <div class="td">
                                    <div class="checkbox-wrapper divheure">
                                        <input type="checkbox" x-model="to_delete" :value="{{16}}" class="a">
                                    </div>
                                </div>
                            </td>
                        @else
                            <td>
                                <div class="td">
                                    <div class="checkbox-wrapper divheure">
                                        <input type="checkbox" x-model="to_add" :value="{{16}}" class="b">
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>13h30 a 17h30</td>
                        @if($HeureLibreEditable !== null && in_array(17, $HeureLibreEditable))
                            <td>
                                <div class="checkbox-wrapper divheure">
                                    <input type="checkbox" x-model="to_delete" :value="{{17}}" class="a">
                                </div>
                            </td>
                        @else
                            <td>
                                <div class="checkbox-wrapper divheure">
                                    <input type="checkbox" x-model="to_add" :value="{{17}}" class="b">
                                </div>
                            </td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </div>
           {{-- <div x-show="to_add.length > 0 || to_delete.length > 0">
                <button x-on:click="$wire.exec([...new Set(to_add.filter(id => !to_delete.includes(id)))], to_delete)">
                    Soumettre
                </button>
              --}}{{--  <span x-text="'Contenu de to_add : ' + JSON.stringify([...new Set(to_add.filter(id => !to_delete.includes(id)))])"></span>
                <span x-text="'Contenu de to_delete : ' + JSON.stringify(to_delete)"></span>--}}{{--
            </div>--}}
        </div>
    @else
        <div class="details" x-data="{ to_add: $wire.entangle('to_add'), to_delete: $wire.entangle('to_delete') }" style=" display: flex !important; ">
            <div class="recentOrders" style=" min-height: 50px; width: 100%;">
                <div class="cardHeader">
                    <div style="display: flex; ">
                        <select class="selection1" name="classe" wire:change="setClass($event.target.value)">
                            @foreach($classes as $cla)
                                <option value="{{ $cla['id'] }}">{{ $cla['niveau'].$cla['numero'].$cla['specialite'] }}</option>
                            @endforeach
                        </select>

                        <select class="selection1" style="margin-left: 7px;" name="week" wire:change="setWeek($event.target.value)">
                            <option value="{{$weeks[0]}}">Semaine en cours </option>
                            <option value="{{$weeks[1]}}">Semaine Prochaine</option>
                        </select>
                        <div style="margin-left: 15px; margin-top: 5px;">
                            {{ $jours[0] }} au {{ $jours[1] }} des {{$class->niveau.$class->numero.$class->specialite}}
                        </div>

                    </div>


                    <div x-show="to_add.length > 0 || to_delete.length > 0">
                        <button class="btnre" x-on:click="$wire.exec([...new Set(to_add.filter(id => !to_delete.includes(id)))], to_delete)">
                            Soumettre
                        </button>
                        {{--                <span x-text="'Contenu de to_add : ' + JSON.stringify([...new Set(to_add.filter(id => !to_delete.includes(id)))])"></span>--}}
                        {{--                <span x-text="'Contenu de to_delete : ' + JSON.stringify(to_delete)"></span>--}}
                    </div>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Heures</th>
                        <th>Lundi</th>
                        <th>Mardi</th>
                        <th>Mercredi</th>
                        <th>Jeudi</th>
                        <th>Vendredi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 1; $i < 3; $i++)
                        <tr>
                            <td>{{ $slots[$i] }}</td>
                            @for($j = 1; $j < 6; $j++)
                                @php
                                    $id = ($i - 1) * 5 + $j;
                                @endphp
                                @if($HeureLibreEditable !== null && in_array($id, $HeureLibreEditable))
                                    <td>
                                        <div class="td">
                                            <div class="checkbox-wrapper divheure">
                                                <input type="checkbox" x-model="to_delete" :value="{{$id}}" class="a">
                                            </div>
                                        </div>
                                    </td>
                                @else
                                    <td>
                                        <div class="td">
                                            <div class="checkbox-wrapper divheure">
                                                <input type="checkbox" x-model="to_add" :value="{{$id}}" class="b">
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            @endfor
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>

        </div>
    @endif

    <style>



        input[type="checkbox"].a:not(:checked){
            background-color: green;
            color: #fff;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 100%;
            height: 100%;
            outline: none;
            cursor: pointer;
            border-radius: 50%;
        }
        input[type="checkbox"].a:checked{
            background-color: red;
            color: #fff;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 100%;
            height: 100%;
            outline: none;
            cursor: pointer;
            border-radius: 50%;
        }
        input[type="checkbox"].b:not(:checked){
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 100%;
            height: 100%;
            outline: none;
            cursor: pointer;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 50%;
        }
        input[type="checkbox"].b:checked{
            background-color: #4e555b;
            color: #fff;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 100%;
            height: 100%;
            outline: none;
            cursor: pointer;
            border-radius: 50%;
        }
        /*.b{*/
        /*    width: 100%;*/
        /*    height: 100%;*/
        /*    outline: none;*/
        /*    cursor: pointer;*/
        /*    background-color: #000000;*/
        /*    border: 1px solid #ccc;*/
        /*    border-radius: 50%;*/
        /*}*/

    </style>
</div>
