<div>
    <div>Compteur : {{$count}}</div>
    <div> statut : {{$state}}</div>
    <button wire:click="increment()" >+</button>
    <button wire:click="decrement()">-</button>
    <button wire:click="uptadedState('on')">on</button>
    <button wire:click="uptadedState('off')">off</button>

    {{-- Care about people's approval and you will be their prisoner. --}}
</div>
