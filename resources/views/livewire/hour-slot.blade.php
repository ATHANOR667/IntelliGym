<div>
    {{-- Because she competes with no one, no one can compete with her. --}}

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



    <div class="calendar details" x-data="{ to_add: $wire.entangle('to_add'), to_delete: $wire.entangle('to_delete') }">
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
                </div>
            </div>
        <table>
            <thead>
            <tr>
                <th>{{ $jours[0] }} au {{ $jours[1] }} des {{$class->niveau.$class->numero.$class->specialite}}</th>
                <th>Lundi</th>
                <th>Mardi</th>
                <th>Mercredi</th>
                <th>Jeudi</th>
                <th>Vendredi</th>
                <th>Samedi</th>
                <th>Dimanche</th>
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
    <style>







        /*input[type="checkbox"] {*/
        /*    appearance: none;*/
        /*    -webkit-appearance: none;*/
        /*    -moz-appearance: none;*/
        /*    width: 100%;*/
        /*    height: 50px;*/
        /*    outline: none;*/
        /*    cursor: pointer;*/
        /*}*/


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

    </style>
</div>
