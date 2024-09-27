<div class="details" x-data="{selection: @entangle('selection')}" style=" display: flex !important; flex-direction: column !important;">


    <div class="recentOrders" style=" min-height: 50px; width: 100%;">
        <div class="cardHeader">
            <div style="display: flex;">
                <div>
                    {{--                <label for="recherche">Rechercher un{{ $column }} </label>--}}
                    <input class="selection1" name="recherche" type="text" wire:model.live.debounce.500ms="search" placeholder="Rechercher un etudiant">
                </div>
                <select class="selection1" name="classe"  wire:change="setClasse($event.target.value)" style="margin-left: 10px;">
                    <option value="" >Toutes</option>
                    @foreach($classes as $classe)
                        <option value="{{$classe->id}}">{{ $classe->niveau.$classe->numero.$classe->specialite }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btnre" x-show="selection.length > 0" x-on:click="$wire.deleteUsers(selection)" > Supprimer</button>
        </div>
        <table>
            <thead>
            <tr>
                <td> Select </td>
                <x-order-arrow :direction="$direction" :field="$column" name="classe_id" wire:click="setColumn('classe_id')" >Classe</x-order-arrow>
                <x-order-arrow :direction="$direction" :field="$column" name="id" wire:click="setColumn('id')" >Id</x-order-arrow>
                <x-order-arrow :direction="$direction" :field="$column" name="matricule" wire:click="setColumn('matricule')">Matricule</x-order-arrow>
                <x-order-arrow :direction="$direction" :field="$column" name="nom" wire:click="setColumn('nom')">Nom</x-order-arrow>
                <x-order-arrow :direction="$direction" :field="$column" name="prenom" wire:click="setColumn('prenom')">Prenom</x-order-arrow>
                <x-order-arrow :direction="$direction" :field="$column" name="date_naiss" wire:click="setColumn('date_naiss')">Date de naissance</x-order-arrow>
                <x-order-arrow :direction="$direction" :field="$column" name="active" wire:click="setColumn('active')">Actif</x-order-arrow>
                <x-order-arrow :direction="$direction" :field="$column" name="sexe" wire:click="setColumn('sexe')">Sexe</x-order-arrow>
            </tr>
            </thead>

            <tbody>

            @foreach($users as $user)
                <tr>
                    {{--                <td><input type="checkbox" x-model="selection" value="{{$user->id}}" > </td>--}}
                    <td>
                        <div class="divoptions">
                            <label class="divcheck">
                                <input type="checkbox" class="checkbox" x-model="selection" value="{{$user->id}}" >
                                <span class="slider"></span>
                            </label>
                        </div>
                    </td>
                    @php $classe =      \App\Models\Classe::find($user->classe_id)              @endphp
                    <td><div>{{$classe->niveau.$classe->numero.$classe->specialite }}</div></td>
                    <td>{{$user->id}}</td>
                    <td>{{$user->matricule}}</td>
                    <td>{{$user->nom}}</td>
                    <td>{{$user->prenom}}</td>
                    <td>{{$user->date_naiss}}</td>
                    @if($user->active)
                        <td>Actif</td>
                    @else
                        <td>Inactif</td>
                    @endif
                    <td>{{$user->sexe}}</td>
                    <td wire:click="startEdit({{$user->id}})"><button class="btnre">Edider</button></td>
                </tr>
                            <tr>
                                <td>
                                    @if($user->id == $editId)
                                    {{--<livewire:users-update :admin="$admin" :user="$user" :column="$column"/>--}}
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
                                                    <input type="text" name="matricule" wire:model="matricule" value="{{$user->matricule}}">
                                                    @error('matricule')
                                                    <span>{{$message}}</span>
                                                    @enderror
                                                    <button type="submit" class="btnre">Enregistrer</button>
                                                @elseif($column == 'nom')
                                                    <input type="text" name="nom" placeholder="nom"  wire:model="nom" value="{{$user->nom}}">
                                                    @error('nom')
                                                    <span>{{$message}}</span>
                                                    @enderror
                                                    <button type="submit" class="btnre">Enregistrer</button>
                                                @elseif($column == 'prenom')
                                                    <input type="text" name="prenom" placeholder="prenom"  wire:model="prenom" value="{{$user->prenom}}">
                                                    @error('prenom')
                                                    <span>{{$message}}</span>
                                                    @enderror
                                                    <button type="submit" class="btnre">Enregistrer</button>
                                                @elseif($column == 'date_naiss')
                                                    <input type="date" name="date_naiss" placeholder="date_naiss"  wire:model="date_naiss" value="{{$user->date_naiss}}">
                                                    @error('date_naiss')
                                                    <span>{{$message}}</span>
                                                    @enderror
                                                    <button type="submit" class="btnre">Enregistrer</button>
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
                                                @elseif($column == 'sexe')
                                                    <select name="sexe" >
                                                        <option value="M"  >homme</option>
                                                        <option value="F" >femme</option>
                                                    </select>
                                                    <button type="submit" class="btnre">Enregistrer</button>
                                                @elseif($column == 'active')
                                                    Le Champ est non modifiable
                                                @endif
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
