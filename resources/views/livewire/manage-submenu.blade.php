<div>

    <div x-data="{
        destroySubItem(subItemId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¡No podrás revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', subItemId);
                }
            });
        }
    }"
    x-init="new Sortable($refs.subitems, {
        group: 'shared',
        animation: 150,
        handle: '.handle-lesson',
        ghostClass: 'blue-background-class',
        store: {
            set: (sortable) => {
                const sorts = sortable.toArray();

                Livewire.dispatch('sortSubItems', {
                    sorts: sorts,
                    itemId: {{ $item->id }}
                });
            }
        }
    });"> 
        {{-- Lista de subitems --}}
        <ul class="space-y-4 mb-6" x-ref="subitems">

            @foreach ($subItems->sortBy('order') as $subItem)
                <li wire:key="subitem-{{$subItem->id}}" data-id="{{ $subItem->id }}">
                    <div class="bg-white rounded-lg shadow-lg px-6 py-4">

                        @if ($formSubItemEdit['id'] == $subItem->id)
                            
                            <form wire:submit="update">

                                <x-wire-input label="Nombre" type="text" wire:model="formSubItemEdit.name"
                                    placeholder="Ingrese el nombre del submenú" />

                                <x-wire-input label="Url" type="text" wire:model="formSubItemEdit.url"
                                    placeholder="Ingrese la url del submenú" />

                                <x-wire-input label="Ícono" type="text" wire:model="formSubItemEdit.icon"
                                    placeholder="Ingrese el ícono del submenú" />
                            
                                <div class="flex justify-end mt-4">
                                    <x-wire-button red wire:click="cancelEdit">
                                        Cancelar
                                    </x-wire-button>
                            
                                    <x-wire-button type="submit" dark class="ml-2">
                                        Actualizar
                                    </x-wire-button>
                                </div>
                            </form>

                        @else
                        
                            <div class="flex">
                                <h1 class="truncate flex-1 cursor-move handle-lesson">
                                    <i class="fas fa-plus text-blue-600 mr-2 hidden md:inline"></i>
                                    {{$subItem->name}}
                                </h1>

                                <div class="ml-4 shrink-0 flex items-center justify-end space-x-3">
                                    <button class="hover:text-indigo-600 disabled:text-gray-300 cursor-pointer"
                                        wire:click="edit({{$subItem->id}})" wire:target="edit({{$subItem->id}})"
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button x-on:click="destroySubItem({{ $subItem->id }})">
                                        <i class="far fa-trash-alt hover:text-red-600 cursor-pointer"></i>
                                    </button>
                                </div>
                            </div>

                        @endif

                    </div>
                </li>
            @endforeach

        </ul>
    </div>

    <div x-data="{
        open: @entangle('formSubItem.open'),
    }">
        <button x-on:click="open = !open"
            class="h-6 w-12 -ml-4 bg-indigo-200 hover:bg-indigo-300 flex items-center justify-center cursor-pointer"
            style="clip-path: polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 0 51%, 0% 0%);">
    
            <i class="-ml-2 text-sm fas fa-plus transition duration-300" :class="{ 'transform rotate-45': open }"></i>
        </button>
    
        <form wire:submit="store" class="bg-white rounded-lg shadow-lg mt-4 hidden" :class="{ 'hidden': !open }">
    
            <div class="p-6 space-y-4">

                <x-wire-input label="Nombre" type="text" wire:model="formSubItem.name"
                    placeholder="Ingrese el nombre del submenú" />

                <x-wire-input label="Url" type="text" wire:model="formSubItem.url"
                    placeholder="Ingrese la url del submenú" />

                <x-wire-input label="Ícono" type="text" wire:model="formSubItem.icon"
                    placeholder="Ingrese el ícono del submenú" />
    
            </div>
    
            <div class="sm:flex sm:justify-end px-6 py-4 bg-gray-100 sm:space-x-2 space-y-2 sm:space-y-0">
                <x-wire-button red class="w-full sm:w-auto" x-on:click="open = false">
                    Cancelar
                </x-wire-button>
    
                <x-wire-button dark class="w-full sm:w-auto text-center" type="submit">
                    Agregar
                </x-wire-button>
            </div>
        </form>
    </div>
</div>