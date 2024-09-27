<div>
    <form wire:submit="save">
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

        @if($column == 'id')
            Le Champ id non modifiable
        @elseif($column == 'classe_id')
            <select  name="classe_id" placeholder="classe_id"  wire:model="classe_id" value="{{$classe->niveau.$classe->numero.$classe->specialite}}">
                @foreach($classes as $classe)
                    <option value="{{$classe->id}}">{{ $classe->niveau.$classe->numero.$classe->specialite }}</option>
                @endforeach
            </select>
            @error('classe_id')
            <span>{{$message}}</span>
            @enderror
            <button type="submit" class="btnre">Enregistrer</button>
        @elseif($column == 'matricule')
            <input type="text" name="matricule" wire:model="matricule" value="{{$user->matricule}}">
            @error('matricule')
            <span>{{$message}}</span>
            @enderror
            <button type="submit">Enregistrer</button>
        @elseif($column == 'nom')
            <input type="text" name="nom" placeholder="nom"  wire:model="nom" value="{{$user->nom}}">
            @error('nom')
            <span>{{$message}}</span>
            @enderror
            <button type="submit">Enregistrer</button>
        @elseif($column == 'prenom')
            <input type="text" name="prenom" placeholder="prenom"  wire:model="prenom" value="{{$user->prenom}}">
            @error('prenom')
            <span>{{$message}}</span>
            @enderror
            <button type="submit">Enregistrer</button>
        @elseif($column == 'date_naiss')
            <input type="date" name="date_naiss" placeholder="date_naiss"  wire:model="date_naiss" value="{{$user->date_naiss}}">
            @error('date_naiss')
            <span>{{$message}}</span>
            @enderror
            <button type="submit">Enregistrer</button>
        @elseif($column == 'sexe')
            <select name="sexe" >
                <option value="M"  >homme</option>
                <option value="F" >femme</option>
            </select>
            <button type="submit">Enregistrer</button>
        @elseif($column == 'active')
            Le Champ est non modifiable
        @endif
    </form>
</div>
