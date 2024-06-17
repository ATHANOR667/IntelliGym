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
        @elseif($column == 'matricule')
            <input type="text" name="matricule" wire:model.live="user.matricule" value="{{$user->matricule}}">
            @error('user.matricule')
            <span>{{$message}}</span>
            @enderror
            <button type="submit">Enregistrer</button>
        @elseif($column == 'nom')
            <input type="text" name="nom" placeholder="nom"  wire:model.live="user.nom" value="{{$user->nom}}">
            @error('user.nom')
            <span>{{$message}}</span>
            @enderror
            <button type="submit">Enregistrer</button>
        @elseif($column == 'prenom')
            <input type="text" name="prenom" placeholder="prenom"  wire:model.live="user.prenom" value="{{$user->prenom}}">
            @error('user.prenom')
            <span>{{$message}}</span>
            @enderror
            <button type="submit">Enregistrer</button>
        @elseif($column == 'date_naiss')
            <input type="date" name="date_naiss" placeholder="date_naiss"  wire:model.live="user.date_naiss" value="{{$user->date_naiss}}">
            @error('user.date_naiss')
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
