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



    <div class="calendar details" x-data="{ to_add: $wire.entangle('to_add'), to_delete: $wire.entangle('to_delete') }">
        <div class="recentOrders" style=" min-height: 50px;">
            <div class="cardHeader">
                <h2>Reservations </h2><br>
                <span>Semaine du {{ $jours[0] }} au {{ $jours[1] }} des {{$class->niveau.$class->numero.$class->specialite}}</span>
                <select class="selection1 " name="week" wire:change="setWeek($event.target.value)">
                    <option class="optio" value="{{$weeks[0]}}">Semaine en cours </option>
                    <option class="optio" value="{{$weeks[1]}}">Semaine Prochaine</option>
                </select>
                <div x-show="to_add.length > 0 || to_delete.length > 0">
                    <button class="btnre" x-on:click="$wire.exec([...new Set(to_add.filter(id => !to_delete.includes(id)))], to_delete)">
                        Soumettre
                    </button>
                </div>
            </div>
            <table>
                <thead>
                <tr class="trview1">
                    {{--                    <th>{{ $jours[0] }} au {{ $jours[1] }}</th>--}}
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
                            @if($NoBookableHour !== null && in_array($id, $NoBookableHour))
                                <td >
                                    {{--                                 {{$id}}--}}
                                    <div class="td">
                                        <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
                                            <div class="checkbox-wrapper divheure">
                                                <div class="b"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td >
                            @elseif($BookedHour !== null && in_array($id, $BookedHour))
                                <td >
                                    {{--                                {{$id}}--}}
                                    <div class="td">
                                        <div class="checkbox-wrapper divheure">
                                            <input type="checkbox" x-model="to_delete" :value="{{$id}}" class="a">
                                        </div>
                                    </div>
                                </td>
                            @else
                                <td >
                                    {{--                                {{$id}}--}}
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
        <!-- ========== new customer ========== -->
        <div class="recentCustomers">
            <div class="cardHeader">
                <h2>Mes reservations</h2>
            </div>

            <table>
                <tr>
                    <td width="60px">
                        <h4>Date</h4>
                    </td>
                    <td><span class="statuts">Debut</span></td>
                    </td>
                </tr>

                @foreach($books as $book)
                    <tr>
                        <td width="70%">
                            <h4>{{$book->jour}}-{{$book->mois}} <br> <span>{{$book->d_o_w}}</span></h4>
                        </td>
                        <td width="30%">
                           <span>Commence a : {{$book->debut}}h</span>
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
            background-color: rgba(96, 98, 96, 0.56);
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
        .b{
            width: 100%;
            height: 100%;
            outline: none;
            cursor: pointer;
            background-color: #000000;
            /*border: 1px solid #ccc;*/
            border-radius: 50%;
        }

    </style>
</div>
