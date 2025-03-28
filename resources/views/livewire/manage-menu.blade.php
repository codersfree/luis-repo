<div>
    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{route('dashboard')}}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Menu</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div x-data x-init="
        new Sortable($refs.items, {
            animation: 150,
            handle: '.handle',
            animation: 150,
            ghostClass: 'blue-background-class',
            store: {
                set: (sortable) => {
                    const sorts = sortable.toArray();
                    @this.sortItems(sorts);
                }
            }
        });
    ">

        <ul class="space-y-6 mb-6" x-ref="items">
            @foreach ($items as $item)
                
                <li wire:key="item-{{$item->id}}" data-id="{{ $item->id }}">

                    <div class="bg-gray-100 rounded-lg shadow-lg px-6 py-4">
                        @if ($formItemEdit['id'] == $item->id)

                            <form wire:submit="updateItem" class="space-y-2">
                                
                                <p class="hidden md:block">
                                    Editar item {{ $loop->iteration }}:
                                </p>
                                
                                <x-wire-input label="Nombre" wire:model="formItemEdit.name" />

                                <x-wire-input label="Url" wire:model="formItemEdit.url" />

                                <x-wire-input label="Icon" wire:model="formItemEdit.icon" />
                                
                                <div class="sm:flex md:justify-end space-y-2 sm:space-y-0 sm:space-x-2">
                                    <x-wire-button
                                        red 
                                        class="w-full sm:w-auto"
                                        wire:click="cancelEdit">
                                        Cancelar
                                    </x-wire-button>
                            
                                    <x-wire-button
                                        dark
                                        class="w-full sm:w-auto"
                                        type="submit" 
                                        wire:target="updateItem">
                                        Actualizar
                                    </x-wire-button>
                                </div>
                            </form>

                        @else

                            <div class="flex items-center">

                                <h1 class="flex-1 truncate cursor-move handle">
                                    <span class="hidden md:inline-block">
                                        Item {{ $loop->iteration }}:
                                    </span> 
                                    <span class="font-semibold">
                                        {{ $item->name }}
                                    </span>
                                </h1>
                            
                                <div class="shrink-0 space-x-2 ml-4">
                                    <button wire:click="editItem({{ $item->id }})" class="hover:text-indigo-600 disabled:text-gray-300 cursor-pointer"
                                        wire:loading.attr="disabled" wire:target="editItem({{ $item->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                            
                                    <button x-on:click="destroyItem({{ $item->id }})">
                                        <i class="far fa-trash-alt hover:text-red-600 cursor-pointer"></i>
                                    </button>
                                </div>
                            </div>
                                
                        @endif

                        <div>
                            @livewire('manage-submenu', [
                                'item' => $item,
                                'subItems' => $item->subItems
                            ], key('manage-submenu-' . $item->id))
                        </div>
                    </div>

                </li>

            @endforeach
        </ul>

    </div>

    <div x-data="{ 
        open: @entangle('formItem.open'),
    }">

        <div x-on:click="open = !open"
            class="h-6 w-12 -ml-4 bg-indigo-50 hover:bg-indigo-200 flex items-center justify-center cursor-pointer"
            style="clip-path: polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 0 51%, 0% 0%);">
    
            <i class="-ml-2 text-sm fas fa-plus transition duration-300" :class="{ 'transform rotate-45': open }"></i>
        </div>
    
        <form wire:submit="storeItem" class="bg-gray-50 rounded-lg shadow-lg p-6 mt-4 hidden space-y-4" :class="{ 'hidden': !open }">
    
            <x-wire-input label="Nombre" wire:model="formItem.name" placeholder="Escriba el nombre" />
    
            <x-wire-input label="Url" wire:model="formItem.url" placeholder="Escriba la url" />

            <x-wire-input label="Icon" wire:model="formItem.icon" placeholder="Escriba el icono" />

            <div class="flex justify-end">
                <x-wire-button red x-on:click="open = false">
                    Cancelar
                </x-wire-button>
    
                <x-wire-button type="submit" black class="ml-2" wire:target="store" wire:loading.attr="disabled">
                    Agregar
                </x-wire-button>
            </div>
    
        </form>
    
    </div>


    @push('js')
        <script>
            function destroyItem(ItemId) {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¡Sí, bórralo!",
                    cancelButtonText: "Cancelar"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        @this.destroyItem(ItemId);
                    }
                });
            }
        </script>
    @endpush

</div>
