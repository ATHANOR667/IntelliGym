 <div>
     <th wire:click="setColumn('{{ $name }}')">
         {{ $slot }}
         @if ($visible)
             @if ($direction == 'ASC')
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                     <path d="M7 14l5-5 5 5z" />
                 </svg>
             @else
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                     <path d="M7 10l5 5 5-5z" />
                 </svg>
             @endif
         @endif
     </th>
 </div>
