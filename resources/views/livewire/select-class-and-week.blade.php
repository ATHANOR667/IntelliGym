<div >

    <select name="classe" wire:change="setClass($event.target.value)">
        @foreach($classes as $cla)
            <option value="{{ $cla }}">{{ $cla }}</option>
        @endforeach
    </select>

    <select name="week" wire:change="setWeek($event.target.value)">
        <option value="{{$weeks[0]}}">Semaine en cours </option>
        <option value="{{$weeks[1]}}">Semaine Prochaine</option>
    </select>

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
